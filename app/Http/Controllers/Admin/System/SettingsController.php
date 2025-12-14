<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SettingsController extends BaseAdminController
{
    const VISIBLE_SETTINGS = [
        'APP_NAME',
        'APP_ENV',
        'APP_DEBUG',
        'APP_URL',
        'ASSET_URL',
        'IMAGE_DIR',
        'COVER_LETTER_DIR',
        'RESUME_DIR',
        'APP_LOCALE',
        'APP_FALLBACK_LOCALE',
        'APP_FAKER_LOCALE',
        'APP_MAINTENANCE_DRIVER',
        'APP_MAINTENANCE_STORE',
        'APP_OWNER',
        'APP_COPYRIGHT',
        'APP_OPEN_ENROLLMENT',
        'APP_READONLY',
        'APP_CONTACTABLE',
        'APP_ADMIN_LOGIN_ENABLED',
        'APP_USER_LOGIN_ENABLED',
        'APP_FEATURED_ADMIN',
        'APP_DEMO_URL',
        'APP_DEMO_ADMIN_ENABLED',
        'APP_DEMO_ADMIN_USERNAME',
        'APP_DEMO_ADMIN_PASSWORD',
        'APP_DEMO_USER_ENABLED',
        'APP_DEMO_USER_USERNAME',
        'APP_DEMO_USER_PASSWORD',
        'APP_DATE_FORMAT_SHORT',
        'APP_DATE_FORMAT_LONG',
        'APP_DATETIME_FORMAT_SHORT',
        'APP_DATETIME_FORMAT_LONG',
        'APP_THEME',
        'CAPTCHA_DISABLE',
        'MATH_ENABLE',
        'PHP_CLI_SERVER_WORKERS',
        'BCRYPT_ROUNDS',
        'LOG_CHANNEL',
        'LOG_STACK',
        'LOG_DEPRECATIONS_CHANNEL',
        'LOG_LEVEL',
        'DB_CONNECTION',
        'DB_HOST',
        'DB_PORT',
        'DB_DATABASE',
        'SYSTEM_DB_CONNECTION',
        'SYSTEM_DB_HOST',
        'SYSTEM_DB_PORT',
        'SYSTEM_DB_DATABASE',
        'DICTIONARY_DB_CONNECTION',
        'DICTIONARY_DB_HOST',
        'DICTIONARY_DB_PORT',
        'DICTIONARY_DB_DATABASE',
        'CAREER_DB_CONNECTION',
        'CAREER_DB_HOST',
        'CAREER_DB_PORT',
        'CAREER_DB_DATABASE',
        'PORTFOLIO_DB_CONNECTION',
        'PORTFOLIO_DB_HOST',
        'PORTFOLIO_DB_PORT',
        'PORTFOLIO_DB_DATABASE',
        'PERSONAL_DB_CONNECTION',
        'PERSONAL_DB_HOST',
        'PERSONAL_DB_PORT',
        'PERSONAL_DB_DATABASE',
        'SESSION_DRIVER',
        'SESSION_LIFETIME',
        'SESSION_ENCRYPT',
        'SESSION_PATH',
        'SESSION_DOMAIN',
        'BROADCAST_CONNECTION',
        'FILESYSTEM_DISK',
        'QUEUE_CONNECTION',
        'CACHE_STORE',
        'CACHE_PREFIX',
        'MEMCACHED_HOST',
        'REDIS_CLIENT',
        'REDIS_HOST',
        'REDIS_PORT',
        'MAIL_MAILER',
        'MAIL_SCHEME',
        'MAIL_HOST',
        'MAIL_PORT',
        'MAIL_FROM_ADDRESS',
        'MAIL_FROM_NAME',
        'AWS_ACCESS_KEY_ID',
        'AWS_SECRET_ACCESS_KEY',
        'AWS_DEFAULT_REGION',
        'AWS_BUCKET',
        'AWS_USE_PATH_STYLE_ENDPOINT',
        'GOOGLE_TAG',
        'VITE_APP_NAME',
    ];

    /**
     * Display the .env settings file.
     *
     * @param Request $request
     * @return View
     */
    public function show(Request $request): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can view this page.');
        }

        $envSettings = [];

        $envFilePath = base_path('.env');

        $handle = fopen($envFilePath, 'r'); // Example for a file in storage/app

        if ($handle) {

            while (($line = fgets($handle)) !== false) {

                if ((substr($line, 0, 1) !== '#') && (false !== $pos = strpos($line, '='))) {

                    $setting = explode('=', $line)[0];
                    $value = explode('=', $line)[1] ?? '';

                    if (in_array(trim($setting), self::VISIBLE_SETTINGS)) {

                        $envSettings[] = $line;

                    } else {

                        $newValue = '';
                        foreach (str_split($value) as $char) {
                            $newValue .= !empty($char) ? '*' : $char;
                        }
                        $envSettings[] = $setting . '=' . $newValue;
                    }

                } else {

                    $envSettings[] = $line;
                }
            }

            fclose($handle);

        } else {
            echo "Error: Could not open the .env file.";
        }

        return view('admin.system.settings.show', compact('envSettings'));
    }
}
