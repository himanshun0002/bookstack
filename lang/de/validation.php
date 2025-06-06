<?php
/**
 * Validation Lines
 * The following language lines contain the default error messages used by
 * the validator class. Some of these rules have multiple versions such
 * as the size rules. Feel free to tweak each of these messages here.
 */
return [

    // Standard laravel validation lines
    'accepted'             => ':attribute muss akzeptiert werden.',
    'active_url'           => ':attribute ist keine gültige URL.',
    'after'                => ':attribute muss ein Datum nach :date sein.',
    'alpha'                => ':attribute kann nur Buchstaben enthalten.',
    'alpha_dash'           => ':attribute kann nur Buchstaben, Zahlen und Bindestriche enthalten.',
    'alpha_num'            => ':attribute kann nur Buchstaben und Zahlen enthalten.',
    'array'                => ':attribute muss ein Array sein.',
    'backup_codes'         => 'Der angegebene Code ist ungültig oder wurde bereits verwendet.',
    'before'               => ':attribute muss ein Datum vor :date sein.',
    'between'              => [
        'numeric' => ':attribute muss zwischen :min und :max liegen.',
        'file'    => ':attribute muss zwischen :min und :max Kilobytes groß sein.',
        'string'  => ':attribute muss zwischen :min und :max Zeichen lang sein.',
        'array'   => ':attribute muss zwischen :min und :max Elemente enthalten.',
    ],
    'boolean'              => ':attribute Feld muss wahr oder falsch sein.',
    'confirmed'            => ':attribute stimmt nicht überein.',
    'date'                 => ':attribute ist kein gültiges Datum.',
    'date_format'          => ':attribute entspricht nicht dem Format :format.',
    'different'            => ':attribute und :other müssen unterschiedlich sein.',
    'digits'               => ':attribute muss :digits Stellen haben.',
    'digits_between'       => ':attribute muss zwischen :min und :max Stellen haben.',
    'email'                => ':attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => ':attribute muss mit einem der folgenden Werte: :values enden',
    'file'                 => ':attribute muss als gültige Datei angegeben werden.',
    'filled'               => ':attribute ist erforderlich.',
    'gt'                   => [
        'numeric' => ':attribute muss größer als :value sein.',
        'file'    => ':attribute muss mindestens :value Kilobytes groß sein.',
        'string'  => ':attribute muss mehr als :value Zeichen haben.',
        'array'   => ':attribute muss mindestens :value Elemente haben.',
    ],
    'gte'                  => [
        'numeric' => ':attribute muss größer-gleich :value sein.',
        'file'    => ':attribute muss mindestens :value Kilobytes groß sein.',
        'string'  => ':attribute muss mindestens :value Zeichen enthalten.',
        'array'   => ':attribute muss :value oder mehr Elemente haben.',
    ],
    'exists'               => ':attribute ist ungültig.',
    'image'                => ':attribute muss ein Bild sein.',
    'image_extension'      => ':attribute muss eine gültige und unterstützte Bild-Dateiendung haben.',
    'in'                   => ':attribute ist ungültig.',
    'integer'              => ':attribute muss eine Zahl sein.',
    'ip'                   => ':attribute muss eine gültige IP-Adresse sein.',
    'ipv4'                 => ':attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6'                 => ':attribute muss eine gültige IPv6-Adresse sein.',
    'json'                 => 'Das Attribut muss eine gültige JSON-Zeichenfolge sein.',
    'lt'                   => [
        'numeric' => ':attribute muss kleiner als :value sein.',
        'file'    => ':attribute muss kleiner als :value Kilobytes sein.',
        'string'  => ':attribute muss weniger als :value Zeichen haben.',
        'array'   => ':attribute muss weniger als :value Elemente haben.',
    ],
    'lte'                  => [
        'numeric' => ':attribute muss kleiner oder gleich :value sein.',
        'file'    => ':attribute muss kleiner oder gleich :value Kilobytes sein.',
        'string'  => ':attribute darf höchstens :value Zeichen besitzen.',
        'array'   => ':attribute darf höchstens :value Elemente haben.',
    ],
    'max'                  => [
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'file'    => ':attribute darf nicht größer als :max Kilobyte sein.',
        'string'  => ':attribute darf nicht länger als :max Zeichen sein.',
        'array'   => ':attribute darf nicht mehr als :max Elemente enthalten.',
    ],
    'mimes'                => ':attribute muss eine Datei vom Typ: :values sein.',
    'min'                  => [
        'numeric' => ':attribute muss mindestens :min sein',
        'file'    => ':attribute muss mindestens :min Kilobyte groß sein.',
        'string'  => ':attribute muss mindestens :min Zeichen lang sein.',
        'array'   => ':attribute muss mindesten :min Elemente enthalten.',
    ],
    'not_in'               => 'Das ausgewählte :attribute ist ungültig.',
    'not_regex'            => ':attribute ist kein gültiges Format.',
    'numeric'              => ':attribute muss eine Zahl sein.',
    'regex'                => ':attribute ist in einem ungültigen Format.',
    'required'             => ':attribute ist erforderlich.',
    'required_if'          => ':attribute ist erforderlich, wenn :other :value ist.',
    'required_with'        => ':attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all'    => ':attribute ist erforderlich, wenn :values vorhanden sind.',
    'required_without'     => ':attribute ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => ':attribute ist erforderlich, wenn :values nicht vorhanden sind.',
    'same'                 => ':attribute und :other müssen übereinstimmen.',
    'safe_url'             => 'Der angegebene Link ist möglicherweise nicht sicher.',
    'size'                 => [
        'numeric' => ':attribute muss :size sein.',
        'file'    => ':attribute muss :size Kilobytes groß sein.',
        'string'  => ':attribute muss :size Zeichen lang sein.',
        'array'   => ':attribute muss :size Elemente enthalten.',
    ],
    'string'               => ':attribute muss eine Zeichenkette sein.',
    'timezone'             => ':attribute muss eine gültige Zeitzone sein.',
    'totp'                 => 'Der angegebene Code ist ungültig oder abgelaufen.',
    'unique'               => ':attribute wird bereits verwendet.',
    'url'                  => ':attribute ist kein gültiges Format.',
    'uploaded'             => 'Die Datei konnte nicht hochgeladen werden. Der Server akzeptiert möglicherweise keine Dateien dieser Größe.',

    'zip_file' => ':attribute muss eine Datei innerhalb des ZIP referenzieren.',
    'zip_file_mime' => ':attribute muss eine Datei des Typs :validType referenzieren, gefunden :foundType.',
    'zip_model_expected' => 'Datenobjekt erwartet, aber ":type" gefunden.',
    'zip_unique' => ':attribute muss für den Objekttyp innerhalb des ZIP eindeutig sein.',

    // Custom validation lines
    'custom' => [
        'password-confirm' => [
            'required_with' => 'Passwortbestätigung erforderlich',
        ],
    ],

    // Custom validation attributes
    'attributes' => [],
];
