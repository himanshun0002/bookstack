<?php

namespace BookStack\Users\Models;

use BookStack\Access\Mfa\MfaValue;
use BookStack\Access\Notifications\ResetPasswordNotification;
use BookStack\Access\SocialAccount;
use BookStack\Activity\Models\Favourite;
use BookStack\Activity\Models\Loggable;
use BookStack\Activity\Models\Watch;
use BookStack\Api\ApiToken;
use BookStack\App\Model;
use BookStack\App\Sluggable;
use BookStack\Entities\Tools\SlugGenerator;
use BookStack\Translation\LocaleDefinition;
use BookStack\Translation\LocaleManager;
use BookStack\Uploads\Image;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * Class User.
 *
 * @property int        $id
 * @property string     $name
 * @property string     $slug
 * @property string     $email
 * @property string     $password
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 * @property bool       $email_confirmed
 * @property int        $image_id
 * @property string     $external_auth_id
 * @property string     $system_name
 * @property Collection $roles
 * @property Collection $mfaValues
 * @property ?Image     $avatar
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract, Loggable, Sluggable
{
    use HasFactory;
    use Authenticatable;
    use CanResetPassword;
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email'];

    protected $casts = ['last_activity_at' => 'datetime'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'system_name', 'email_confirmed', 'external_auth_id', 'email',
        'created_at', 'updated_at', 'image_id', 'roles', 'avatar', 'user_id', 'pivot',
    ];

    /**
     * This holds the user's permissions when loaded.
     */
    protected ?Collection $permissions;

    /**
     * This holds the user's avatar URL when loaded to prevent re-calculating within the same request.
     */
    protected string $avatarUrl = '';

    /**
     * Returns the default public user.
     * Fetches from the container as a singleton to effectively cache at an app level.
     */
    public static function getGuest(): self
    {
        return app()->make('users.default');
    }

    /**
     * Check if the user is the default public user.
     */
    public function isGuest(): bool
    {
        return $this->system_name === 'public';
    }

    /**
     * Check if the user has general access to the application.
     */
    public function hasAppAccess(): bool
    {
        return !$this->isGuest() || setting('app-public');
    }

    /**
     * The roles that belong to the user.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        if ($this->id === 0) {
            return;
        }

        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if the user has a role.
     */
    public function hasRole($roleId): bool
    {
        return $this->roles->pluck('id')->contains($roleId);
    }

    /**
     * Check if the user has a role.
     */
    public function hasSystemRole(string $roleSystemName): bool
    {
        return $this->roles->pluck('system_name')->contains($roleSystemName);
    }

    /**
     * Attach the default system role to this user.
     */
    public function attachDefaultRole(): void
    {
        $roleId = intval(setting('registration-role'));
        if ($roleId && $this->roles()->where('id', '=', $roleId)->count() === 0) {
            $this->roles()->attach($roleId);
        }
    }

    /**
     * Check if the user has a particular permission.
     */
    public function can(string $permissionName): bool
    {
        return $this->permissions()->contains($permissionName);
    }

    /**
     * Get all permissions belonging to the current user.
     */
    protected function permissions(): Collection
    {
        if (isset($this->permissions)) {
            return $this->permissions;
        }

        $this->permissions = $this->newQuery()->getConnection()->table('role_user', 'ru')
            ->select('role_permissions.name as name')->distinct()
            ->leftJoin('permission_role', 'ru.role_id', '=', 'permission_role.role_id')
            ->leftJoin('role_permissions', 'permission_role.permission_id', '=', 'role_permissions.id')
            ->where('ru.user_id', '=', $this->id)
            ->pluck('name');

        return $this->permissions;
    }

    /**
     * Clear any cached permissions on this instance.
     */
    public function clearPermissionCache()
    {
        $this->permissions = null;
    }

    /**
     * Attach a role to this user.
     */
    public function attachRole(Role $role)
    {
        $this->roles()->attach($role->id);
        $this->unsetRelation('roles');
    }

    /**
     * Get the social account associated with this user.
     */
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Check if the user has a social account,
     * If a driver is passed it checks for that single account type.
     *
     * @param bool|string $socialDriver
     *
     * @return bool
     */
    public function hasSocialAccount($socialDriver = false)
    {
        if ($socialDriver === false) {
            return $this->socialAccounts()->count() > 0;
        }

        return $this->socialAccounts()->where('driver', '=', $socialDriver)->exists();
    }

    /**
     * Returns a URL to the user's avatar.
     */
    public function getAvatar(int $size = 50): string
    {
        $default = url('/user_avatar.png');
        $imageId = $this->image_id;
        if ($imageId === 0 || $imageId === '0' || $imageId === null) {
            return $default;
        }

        if (!empty($this->avatarUrl)) {
            return $this->avatarUrl;
        }

        try {
            $avatar = $this->avatar?->getThumb($size, $size, false) ?? $default;
        } catch (Exception $err) {
            $avatar = $default;
        }

        $this->avatarUrl = $avatar;

        return $avatar;
    }

    /**
     * Get the avatar for the user.
     */
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    /**
     * Get the API tokens assigned to this user.
     */
    public function apiTokens(): HasMany
    {
        return $this->hasMany(ApiToken::class);
    }

    /**
     * Get the favourite instances for this user.
     */
    public function favourites(): HasMany
    {
        return $this->hasMany(Favourite::class);
    }

    /**
     * Get the MFA values belonging to this use.
     */
    public function mfaValues(): HasMany
    {
        return $this->hasMany(MfaValue::class);
    }

    /**
     * Get the tracked entity watches for this user.
     */
    public function watches(): HasMany
    {
        return $this->hasMany(Watch::class);
    }

    /**
     * Get the last activity time for this user.
     */
    public function scopeWithLastActivityAt(Builder $query)
    {
        $query->addSelect(['activities.created_at as last_activity_at'])
            ->leftJoinSub(function (\Illuminate\Database\Query\Builder $query) {
                $query->from('activities')->select('user_id')
                    ->selectRaw('max(created_at) as created_at')
                    ->groupBy('user_id');
            }, 'activities', 'users.id', '=', 'activities.user_id');
    }

    /**
     * Get the url for editing this user.
     */
    public function getEditUrl(string $path = ''): string
    {
        $uri = '/settings/users/' . $this->id . '/' . trim($path, '/');

        return url(rtrim($uri, '/'));
    }

    /**
     * Get the url that links to this user's profile.
     */
    public function getProfileUrl(): string
    {
        return url('/user/' . $this->slug);
    }

    /**
     * Get a shortened version of the user's name.
     */
    public function getShortName(int $chars = 8): string
    {
        if (mb_strlen($this->name) <= $chars) {
            return $this->name;
        }

        $splitName = explode(' ', $this->name);
        if (mb_strlen($splitName[0]) <= $chars) {
            return $splitName[0];
        }

        return mb_substr($this->name, 0, max($chars - 2, 0)) . '…';
    }

    /**
     * Get the locale for this user.
     */
    public function getLocale(): LocaleDefinition
    {
        return app()->make(LocaleManager::class)->getForUser($this);
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * {@inheritdoc}
     */
    public function logDescriptor(): string
    {
        return "({$this->id}) {$this->name}";
    }

    /**
     * {@inheritdoc}
     */
    public function refreshSlug(): string
    {
        $this->slug = app()->make(SlugGenerator::class)->generate($this);

        return $this->slug;
    }
}
