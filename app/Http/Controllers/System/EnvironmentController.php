<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\View\View;

class EnvironmentController extends BaseSystemController
{
    const array SETTINGS = [
        'ADMIN_TABLE_CLASSES',
        'APP_ADMIN_LOGIN_ENABLED',
        'APP_ADMINS_ENABLED',
        'APP_BOTTOM_COLUMN_HEADINGS',
        'APP_CONTACTABLE',
        'APP_COPYRIGHT',
        'APP_DATE_FORMAT_LONG',
        'APP_DATE_FORMAT_SHORT',
        'APP_DATETIME_FORMAT_LONG',
        'APP_DATETIME_FORMAT_SHORT',
        'APP_DEBUG',
        'APP_DEMO_ADMIN_AUTOLOGIN',
        'APP_DEMO_ADMIN_CAN_EDIT',
        'APP_DEMO_ADMIN_ENABLED',
        //'APP_DEMO_ADMIN_PASSWORD',
        'APP_DEMO_ADMIN_USERNAME',
        'APP_DEMO_DISCLAIMER',
        'APP_DEMO_MODE',
        'APP_DEMO_SINGLE_SITE_URL',
        'APP_DEMO_SITE_URL',
        'APP_DEMO_USER_AUTOLOGIN',
        'APP_DEMO_USER_CAN_EDIT',
        'APP_DEMO_USER_ENABLED',
        //'APP_DEMO_USER_PASSWORD',
        'APP_DEMO_USER_USERNAME',
        'APP_ENV',
        'APP_FAKER_LOCALE',
        'APP_FALLBACK_LOCALE',
        'APP_FEATURED_ADMIN_USERNAME',
        'APP_INCLUDE_SITE_INTRO',
        'APP_KEY',
        //'APP_LOCALE',
        'APP_MAINTENANCE_DRIVER',
        'APP_MAINTENANCE_STORE',
        'APP_NAME',
        'APP_OPEN_ENROLLMENT',
        'APP_OWNER',
        'APP_PAGINATION_BOTTOM',
        'APP_PAGINATION_PER_PAGE',
        'APP_PAGINATION_TEMPLATE',
        'APP_PAGINATION_TOP',
        'APP_READONLY',
        'APP_RECORD_LOGINS',
        'APP_SECURE_URLS',
        'APP_SINGLE_ADMIN_MODE',
        'APP_THEME',
        'APP_TIMESTAMP',
        'APP_TOP_COLUMN_HEADINGS',
        'APP_URL',
        'APP_USER_LOGIN_ENABLED',
        'APP_USERS_ENABLED',
        'APP_VERSION',
        'ASSET_URL',
        //'AWS_ACCESS_KEY_ID',
        'AWS_BUCKET',
        'AWS_DEFAULT_REGION',
        //'AWS_SECRET_ACCESS_KEY',
        'AWS_USE_PATH_STYLE_ENDPOINT',
        'BCRYPT_ROUNDS',
        'BROADCAST_CONNECTION',
        'CACHE_PREFIX',
        'CACHE_STORE',
        'CAREER_DB_CONNECTION',
        'CAREER_DB_DATABASE',
        'CAREER_DB_HOST',
        //'CAREER_DB_PASSWORD',
        'CAREER_DB_PORT',
        'CAREER_DB_USERNAME',
        'COVER_LETTER_DIR',
        'DB_CONNECTION',
        'DB_DATABASE',
        'DB_HOST',
        //'DB_PASSWORD',
        'DB_PORT',
        'DB_USERNAME',
        'DICTIONARY_DB_CONNECTION',
        'DICTIONARY_DB_DATABASE',
        'DICTIONARY_DB_HOST',
        //'DICTIONARY_DB_PASSWORD',
        'DICTIONARY_DB_PORT',
        'DICTIONARY_DB_USERNAME',
        'FACEBOOK_APP_ID',
        'FILESYSTEM_DISK',
        'GOOGLE_TAG',
        'GUEST_TABLE_CLASSES',
        'IMAGE_DIR',
        'LOG_CHANNEL',
        'LOG_DEPRECATIONS_CHANNEL',
        'LOG_LEVEL',
        'LOG_STACK',
        'MAIL_FROM_ADDRESS',
        'MAIL_FROM_NAME',
        'MAIL_HOST',
        'MAIL_MAILER',
        //'MAIL_PASSWORD',
        'MAIL_PORT',
        'MAIL_SCHEME',
        'MAIL_USERNAME',
        'MATH_ENABLE',
        'MEMCACHED_HOST',
        'PERSONAL_DB_CONNECTION',
        'PERSONAL_DB_DATABASE',
        'PERSONAL_DB_HOST',
        //'PERSONAL_DB_PASSWORD',
        'PERSONAL_DB_PORT',
        'PERSONAL_DB_USERNAME',
        'PHP_CLI_SERVER_WORKERS',
        'PORTFOLIO_DB_CONNECTION',
        'PORTFOLIO_DB_DATABASE',
        'PORTFOLIO_DB_HOST',
        //'PORTFOLIO_DB_PASSWORD',
        'PORTFOLIO_DB_PORT',
        'PORTFOLIO_DB_USERNAME',
        'QUEUE_CONNECTION',
        'REDIS_CLIENT',
        'REDIS_HOST',
        //'REDIS_PASSWORD',
        'REDIS_PORT',
        'RESUME_DIR',
        'SESSION_DOMAIN',
        'SESSION_DRIVER',
        'SESSION_ENCRYPT',
        'SESSION_LIFETIME',
        'SESSION_PATH',
        'SHARE_SITES',
        'SITE_COOKIE_NAME',
        'SYSTEM_DB_CONNECTION',
        'SYSTEM_DB_DATABASE',
        'SYSTEM_DB_HOST',
        //'SYSTEM_DB_PASSWORD',
        'SYSTEM_DB_PORT',
        'SYSTEM_DB_USERNAME',
        'UPLOAD_AUDIO_ACCEPT',
        'UPLOAD_DOCUMENT_ACCEPT',
        'UPLOAD_ENABLED',
        'UPLOAD_IMAGE_ACCEPT',
        'UPLOAD_MAX_FILESIZE',
        'UPLOAD_VIDEO_ACCEPT',
        'USER_TABLE_CLASSES',
        'VITE_APP_NAME',
    ];

    /**
     * Display a listing of units.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }


        $envSettings = $this->getEnvSettings();

        $composerJsonContent = $this->getComposerJsonContent();
        $composerLockContent = $this->getComposerLockContent();
        $packageJsonContent = $this->getPackageJsonContent();
        $packageLockContent = $this->getPackageLockContent();

        $pageTitle = 'Environment';

        return view('system.environment.index',
            compact('envSettings',
                'composerJsonContent', 'composerLockContent',
                'packageJsonContent', 'packageLockContent',
                'pageTitle')
        );
    }

    private function getEnvSettings(): array
    {
        $envSettings = [];
        foreach (self::SETTINGS as $setting) {
            $envSettings[$setting] = null;
        }

        $envFilePath = base_path() . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($envFilePath)) {
            abort(500, 'Environment file not found.');
        }

        $handle = fopen($envFilePath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                $line = trim($line);

                if (!empty($line) && str_contains($line, '=')) {

                    // Process each line here
                    if ($property = trim(explode('=', $line)[0])) {

                        $setting = trim($property, '# ');
                        $value = trim(explode('=', $line)[1]);

                        if (array_key_exists($setting, $envSettings)) {
                            $envSettings[$setting] = ($setting != $property) ? '#' .  $value : $value;
                        }
                    }
                }
            }
            fclose($handle);
        } else {
            abort(500, 'Error opening environment file.');
        }

        return $envSettings;
    }

    private function getComposerJsonContent() : string
    {
        $composerJsonFilePath = base_path() . DIRECTORY_SEPARATOR . 'composer.json';

        if (!file_exists($composerJsonFilePath)) {
            return 'composer.json file not found.';
        } else {
            return file_get_contents($composerJsonFilePath);
        }
    }

    private function getComposerLockContent() : string
    {
        $composerLockFilePath = base_path() . DIRECTORY_SEPARATOR . 'composer.json';

        if (!file_exists($composerLockFilePath)) {
            return 'composer.json file not found.';
        } else {
            return file_get_contents($composerLockFilePath);
        }
    }

    private function getPackageJsonContent() : string
    {
        $packageJsonFilePath = base_path() . DIRECTORY_SEPARATOR . 'package.json';

        if (!file_exists($packageJsonFilePath)) {
            return 'package.json file not found.';
        } else {
            return file_get_contents($packageJsonFilePath);
        }
    }

    private function getPackageLockContent() : string
    {
        $packageLockFilePath = base_path() . DIRECTORY_SEPARATOR . 'package-lock.json';

        if (!file_exists($packageLockFilePath)) {
            return 'composer.json file not found.';
        } else {
            return file_get_contents($packageLockFilePath);
        }
    }
}
