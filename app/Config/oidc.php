<?php

return [

    // Display name, shown to users, for OpenId option
    'name' => env('OIDC_NAME', 'SSO'),

    // Dump user details after a login request for debugging purposes
    'dump_user_details' => env('OIDC_DUMP_USER_DETAILS', false),

    // Claim, within an OpenId token, to find the user's display name
    'display_name_claims' => env('OIDC_DISPLAY_NAME_CLAIMS', 'name'),

    // Claim, within an OpenID token, to use to connect a BookStack user to the OIDC user.
    'external_id_claim' => env('OIDC_EXTERNAL_ID_CLAIM', 'sub'),

    // OAuth2/OpenId client id, as configured in your Authorization server.
    'client_id' => env('OIDC_CLIENT_ID', null),

    // OAuth2/OpenId client secret, as configured in your Authorization server.
    'client_secret' => env('OIDC_CLIENT_SECRET', null),

    // The issuer of the identity token (id_token) this will be compared with
    // what is returned in the token.
    'issuer' => env('OIDC_ISSUER', null),

    // Auto-discover the relevant endpoints and keys from the issuer.
    // Fetched details are cached for 15 minutes.
    'discover' => env('OIDC_ISSUER_DISCOVER', false),

    // Public key that's used to verify the JWT token with.
    // Can be the key value itself or a local 'file://public.key' reference.
    'jwt_public_key' => env('OIDC_PUBLIC_KEY', null),

    // OAuth2 endpoints.
    'authorization_endpoint' => env('OIDC_AUTH_ENDPOINT', null),
    'token_endpoint'         => env('OIDC_TOKEN_ENDPOINT', null),
    'userinfo_endpoint'      => env('OIDC_USERINFO_ENDPOINT', null),

    // OIDC RP-Initiated Logout endpoint URL.
    // A false value force-disables RP-Initiated Logout.
    // A true value gets the URL from discovery, if active.
    // A string value is used as the URL.
    'end_session_endpoint' => env('OIDC_END_SESSION_ENDPOINT', false),

    // Add extra scopes, upon those required, to the OIDC authentication request
    // Multiple values can be provided comma seperated.
    'additional_scopes' => env('OIDC_ADDITIONAL_SCOPES', null),

    // Enable fetching of the user's avatar from the 'picture' claim on login.
    // Will only be fetched if the user doesn't already have an avatar image assigned.
    // This can be a security risk due to performing server-side fetching (with up to 3 redirects) of
    // data from external URLs. Only enable if you trust the OIDC auth provider to provide safe URLs for user images.
    'fetch_avatar' => env('OIDC_FETCH_AVATAR', false),

    // Group sync options
    // Enable syncing, upon login, of OIDC groups to BookStack roles
    'user_to_groups' => env('OIDC_USER_TO_GROUPS', false),
    // Attribute, within a OIDC ID token, to find group names within
    'groups_claim' => env('OIDC_GROUPS_CLAIM', 'groups'),
    // When syncing groups, remove any groups that no longer match. Otherwise, sync only adds new groups.
    'remove_from_groups' => env('OIDC_REMOVE_FROM_GROUPS', false),
];
