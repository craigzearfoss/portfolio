<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'asset_url'               => env('ASSET_URL', ''),
    'image_dir'               => env('IMAGE_DIR', ''),
    'resume_dir'              => env('RESUME_DIR', ''),
    'coverLetter_dir'         => env('COVER_LETTER_DIR', ''),
    'copyright'               => env('APP_COPYRIGHT', ''),
    'date_format_short'       => env('APP_DATE_FORMAT_SHORT', 'm/d/Y'),
    'date_format_long'        => env('APP_DATE_FORMAT_LONG', 'F j, Y'),
    'datetime_format_short'   => env('APP_DATETIME_FORMAT_SHORT', 'm/d/Y h:i:s a'),
    'datetime_format_long'    => env('APP_DATETIME_FORMAT_LONG', 'F j, Y h:i:s a'),
    'database'                => env('DB_DATABASE'),
    'system_db'               => env('SYSTEM_DB_DATABASE'),
    'dictionary_db'           => env('DICTIONARY_DB_DATABASE'),
    'career_db'               => env('CAREER_DB_DATABASE'),
    'portfolio_db'            => env('PORTFOLIO_DB_DATABASE'),
    'personal_db'             => env('PERSONAL_DB_DATABASE'),
    'name'                    => env('APP_NAME', 'My Portfolio'),
    'version'                 => env('APP_VERSION', 'beta'),
    'open_enrollment'         => boolval(env('APP_OPEN_ENROLLMENT', false)),
    'owner'                   => env('APP_OWNER', ''),
    'featured_admin'          => env('APP_FEATURED_ADMIN'),
    'admins_enabled'          => boolval(env('APP_ADMINS_ENABLED', true)),
    'admin_login_enabled'     => boolval(env('APP_ADMIN_LOGIN_ENABLED', false)),
    'users_enabled'           => boolval(env('APP_USERS_ENABLED', true)),
    'user_login_enabled'      => boolval(env('APP_USER_LOGIN_ENABLED', false)),
    'demo_mode'               => boolval(env('APP_DEMO_MODE', false)),
    'demo_disclaimer'         => env('APP_DEMO_DISCLAIMER', 'For demonstration purposes only.'),
    'demo_admin_enabled'      => boolval(env('APP_DEMO_ADMIN_ENABLED', false)),
    'demo_admin_url'          => boolval(env('APP_DEMO_ADMIN_URL')),
    'demo_admin_username'     => env('APP_DEMO_ADMIN_USERNAME', ''),
    'demo_admin_password'     => env('APP_DEMO_ADMIN_PASSWORD', ''),
    'demo_admin_autologin'    => boolval(env('APP_DEMO_ADMIN_AUTOLOGIN', false)),
    'demo_user_enabled'       => boolval(env('APP_DEMO_USER_ENABLED', false)),
    'demo_user_username'      => env('APP_DEMO_USER_USERNAME', ''),
    'demo_user_password'      => env('APP_DEMO_USER_PASSWORD', ''),
    'demo_user_autologin'     => boolval(env('APP_DEMO_USER_AUTOLOGIN', false)),
    'readonly'                => boolval(env('APP_READONLY', false)),
    'record_logins'           => boolval(env('APP_RECORD_LOGINS', false)),
    'contactable'             => boolval(env('APP_CONTACTABLE', false)),
    'theme'                   => env('APP_THEME'),
    'bottom_column_headings'  => boolval(env('APP_BOTTOM_COLUMN_HEADINGS', 0)),
    'upload_enabled'          => boolval(env('APP_UPLOAD_ENABLED', false)),
    'upload_max_file_size'    => intval(env('APP_UPLOAD_MAX_FILE_SIZE', 2048)),
    'upload_image_accept'     => !empty(trim(env('APP_UPLOAD_IMAGE_ACCEPT', '')))
                                     ? explode('|', trim(env('APP_UPLOAD_IMAGE_ACCEPT', '')))
                                     : [],
    'upload_doc_accept'       => !empty(trim(env('APP_UPLOAD_DOC_ACCEPT', '')))
                                     ? explode('|', trim(env('APP_UPLOAD_DOC_ACCEPT', '')))
                                     : [],
    'pagination_per_page'     => intval(env('APP_PAGINATION_PER_PAGE', 20)),
    'pagination_theme'        => env('APP_PAGINATION_TEMPLATE', 'default'),
    'pagination_bottom'       => boolval(env('APP_PAGINATION_BOTTOM', true)),
    'pagination_top'          => boolval(env('APP_PAGINATION_TOP', false)),
    'google_tag'              => env('GOOGLE_TAG', ''),
    'captcha_enabled'         => boolval(env('RECAPTCHA_ENABLED', false)),
    'google_recaptcha_key'    => env('GOOGLE_RECAPTCHA_KEY', ''),
    'google_recaptcha_secret' => env('GOOGLE_RECAPTCHA_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
