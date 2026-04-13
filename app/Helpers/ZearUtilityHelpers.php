<?php

use App\Enums\EnvTypes;
use App\Models\System\Admin;
use App\Models\System\AdminResource;
use App\Models\System\Owner;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Models\System\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;

if (! function_exists('getEnvType')) {
    /**
     * Determines the environment from the current route name.
     *
     * @return EnvTypes
     */
    function getEnvType(): EnvTypes
    {
        $currentRoute = Route::currentRouteName();

        return match (!empty($currentRoute) ? explode('.', $currentRoute)[0] : '') {
            'admin' => EnvTypes::ADMIN,
            'user'  => EnvTypes::USER,
            default => EnvTypes::GUEST,
        };
    }
}

if ( !function_exists('getRouteBase')) {
    /**
     * Returns the base of a route name. For example guest.portfolio.course.index
     * and guest.portfolio.course.show both have a base route of guest.portfolio.course.
     *
     * @param string|null $routeName
     * @return string
     */
    function getRouteBase(string|null $routeName = null): string
    {
        if (empty($routeName)) {
            $routeName = Route::currentRouteName();
        }

        $parts = explode('.', $routeName);
        if (count($parts) > 2) {
            $parts = array_slice($parts, 0, 3);
        } elseif (count($parts) == 2) {
            $parts = array_slice($parts, 0, 3);
        }

        return implode('.', $parts);
    }
}

if (! function_exists('dbName')) {
    /**
     * Returns the name of a database from the database tag.
     * This is because names of databases can be specified in the .env file.
     *
     * @param string $dbTag
     * @return string|null
     */
    function dbName(string $dbTag): string|null  {
        if ($database = Database::query()->where('tag', '=', $dbTag)->first()) {
            return $database->database;
        } else {
            return null;
        }
    }
}

if (! function_exists('refererRouteName')) {
    /**
     * Returns the route name of the refering page or null if there was no refering page.
     *
     * @return string|null
     */
    function refererRouteName(): string|null
    {
        try {
            $referer = Request::header('referer');
            $routeName = app('router')->getRoutes()->match(app('request')->create($referer))->getName();
        } catch (Throwable $th) {
            $routeName = null;
        }

        return $routeName;
    }
}

if (! function_exists('referer')) {
    /**
     * Returns the url of the refering page or the specified fallback route if there was no referer.
     *
     * @param string|null $fallbackRoute
     * @param mixed $parameters
     * @param bool $absolute
     * @return string|null
     */
    function referer(string|null $fallbackRoute = null, mixed $parameters = [], bool $absolute = true): string|null
    {
        $referer = Request::input('referer') ?? (Request::header('referer') ?? null);

        if (empty($referer) && ! empty($fallbackRoute)) {
            try {
                $referer = route($fallbackRoute, $parameters, $absolute);
            } catch (Throwable $th) {
            }
        }

        return $referer;
    }
}

if (! function_exists('loggedInUser')) {
    /**
     * Returns User object of the logged-in user or null if there is not one.
     *
     * @return Admin|null
     */
    function loggedInUser(): Admin|null
    {
        if (! Auth::guard('user')->check()) {
            return null;
        } else {
            return Auth::guard('user')->user();
        }
    }
}

if (! function_exists('loggedInUserId')) {
    /**
     * Returns id of the logged-in user or null if there is no logged-in user.
     *
     * @return int|null
     */
    function loggedInUserId(): int|null
    {
        try {
            if (Auth::guard('user')->check()) {
                return Auth::guard('user')->user()->id;
            } else {
                return null;
            }
        } catch (Throwable $th) {
            return null;
        }
    }
}

if (! function_exists('isUser')) {
    /**
     * Returns true if a user.
     *
     * @return bool
     */
    function isUser(): bool
    {
        try {
            return Auth::guard('user')->check();
        } catch (Throwable $th) {
            return false;
        }
    }
}

if (! function_exists('loggedInAdmin')) {
    /**
     * Returns Admin object of the logged-in admin or null if there is not one.
     *
     * @return Authenticatable|null
     */
    function loggedInAdmin(): Authenticatable|null
    {
        if (!Auth::guard('admin')->check()) {
            return null;
        } else {
            return Auth::guard('admin')->user();
        }
    }
}

if (! function_exists('loggedInAdminId')) {
    /**
     * Returns id of the logged-in admin or null if there is no logged in admin.
     *
     * @return int|null
     */
    function loggedInAdminId(): int|null
    {
        try {
            if (Auth::guard('admin')->check()) {
                return Auth::guard('admin')->user()->id;
            } else {
                return null;
            }
        } catch (Throwable $th) {
            return null;
        }
    }
}

if (! function_exists('isAdmin')) {
    /**
     * Returns true if an admin.
     *
     * @return bool
     */
    function isAdmin(): bool
    {
        try {
            return Auth::guard('admin')->check();
        } catch (Throwable $th) {
            return false;
        }
    }
}

if (! function_exists('isRootAdmin')) {
    /**
     * Returns true if an admin with root privileges.
     *
     * @return bool
     */
    function isRootAdmin(): bool
    {
        try {
            return Auth::guard('admin')->check() && Auth::guard('admin')->user()->is_root;
        } catch (Throwable $th) {
            return false;
        }
    }
}

if (! function_exists('canCreate')) {
    /**
     * Returns true if an admin can create an entity.
     * Parameter #2, $entity, must be the name of an entity (ex. database or resource).
     *
     * @param string $resourceClass
     * @param Admin|null $admin
     * @param EnvTypes $envType
     * @return bool
     */
    function canCreate(string $resourceClass, Admin|null $admin = null, EnvTypes $envType = EnvTypes::ADMIN): bool
    {
        // resources can only be created in the admin environment
        if ($envType != EnvTypes::ADMIN) {
            return false;
        }

        // determine the authorization
        if (empty($admin)) {
            $retValue = false;
        } elseif (boolval($admin['is_root'] ?? 0)) {
            // root admins can create anything
            // @TODO: should we add some limitations
            $retValue = true;
        } else {

            // check the admin's permission for this resource type in the environment
            if (!$adminResource = AdminResource::query()->where('class', '=', $resourceClass)
                ->where('owner_id', '=', $admin['id'])
                ->where($envType->value, '=', true)->first()
            ) {
                $retValue = false;
            } else {
                if (!$adminResource->has_owner) {
                    // only admins can update ownerless resources
                    $retValue = false;
                } else {
                    $retValue = true;
                }
            }
        }

        // return the authorization
        if (!$retValue) {
            return false;
        } else {
            // before returning true make sure it's not for a demo user with editing disabled
            return $admin['is_demo']
                ? config('app.demo_admin_can_edit')
                : true;
        }
    }
}

if (! function_exists('canRead')) {
    /**
     * Returns true if an admin can read an entity.
     * Parameter #1, $resourceObjectOrClass, must be a resource object or a resource class name.
     *
     * @param $resourceObjectOrClass
     * @param Admin|null $admin
     * @param EnvTypes $envType
     * @return bool
     */
    function canRead($resourceObjectOrClass, Admin|null $admin = null, EnvTypes $envType = EnvTypes::ADMIN): bool
    {
        if (boolval($admin['is_root'] ?? 0)) {
            $retValue = true;
        } else {

            if (is_string($resourceObjectOrClass)) {

                $resourceClass = $resourceObjectOrClass;
                $resourceObject = null;

                $resource = Resource::query()->where('class', '=', $resourceClass)
                    ->where($envType->value, '=', true)
                    ->first();

            } else {

                $resourceClass = get_class($resourceObjectOrClass);
                $resourceObject = $resourceObjectOrClass;

                $resource = AdminResource::query()->where('class', '=', $resourceClass)
                    ->where('owner_id', '=', $admin['id'])
                    ->where($envType->value, '=', true)
                    ->first();
            }

            if (empty($resource)) {
                $retValue = false;
            } else {
                // @TODO: should we check the is_public property
                $retValue = true;
            }

        }

        return $retValue;
    }
}

if (! function_exists('canUpdate')) {
    /**
     * Returns true if an admin can update a resource.
     * Only root admins can update entities that belong to other admins.
     *
     * @param $resourceObject
     * @param Admin|null $admin
     * @param EnvTypes $envType
     * @return bool
     */
    function canUpdate($resourceObject, Admin|null $admin = null, EnvTypes $envType = EnvTypes::ADMIN): bool
    {
        // resources can only be updated in the admin environment
        if ($envType != EnvTypes::ADMIN) {
            return false;
        }

        // determine the authorization
        if (empty($admin)) {
            $retValue = false;
        } elseif (boolval($admin['is_root'] ?? 0)) {
            // root admins can update anything
            // @TODO: should we add some limitations
            $retValue = true;
        } elseif ($resourceObject->is_root) {
            // non-root admins cannot update root resources
            $retValue = false;
        } elseif (!$resourceObject->has_owner) {
            // only admins can update ownerless resources
            $retValue = false;
        } elseif ($resourceObject->owner_id !== $admin['id']) {
            $retValue = false;
        } else {

            // check the admin's permission for this resource type in the environment
            if (AdminResource::query()->where('class', '=', get_class($resourceObject))
                ->where('owner_id', '=', $admin['id'])
                ->where($envType->value, '=', true)->first()
            ) {
                $retValue = true;
            } else {
                $retValue = false;
            }
        }

        // return the authorization
        if (!$retValue) {
            return false;
        } else {
            // before returning true make sure it's not for a demo user with editing disabled
            return $admin['is_demo']
                ? config('app.demo_admin_can_edit')
                : true;
        }
    }
}

if (! function_exists('canDelete')) {
    /**
     * Returns true if an admin can delete a resource.
     * Only root admins can update entities that belong to other admins.
     *
     * @param $resourceObject
     * @param Admin|null $admin
     * @param EnvTypes $envType
     * @return bool
     */
    function canDelete($resourceObject, Admin|null $admin = null, EnvTypes $envType = EnvTypes::ADMIN): bool
    {
        // resources can only be deleted in the admin environment
        if ($envType != EnvTypes::ADMIN) {
            return false;
        }

        // determine the authorization
        if (empty($admin)) {
            $retValue = false;
        } elseif (boolval($admin['is_root'] ?? 0)) {
            // root admins can delete anything
            // @TODO: should we add some limitations
            $retValue = true;
        } elseif ($resourceObject->is_root) {
            // non-root admins cannot delete root resources
            $retValue = false;
        } elseif (!$resourceObject->has_owner) {
            // only admins can delete ownerless resources
            $retValue = false;
        } elseif ($resourceObject->owner_id !== $admin['id']) {
            $retValue = false;
        } else {

            // check the admin's permission for this resource type in the environment
            if (AdminResource::query()->where('class', '=', get_class($resourceObject))
                ->where('owner_id', '=', $admin['id'])
                ->where($envType->value, '=', true)->first()
            ) {
                $retValue = true;
            } else {
                $retValue = false;
            }
        }

        // return the authorization
        if (!$retValue) {
            return false;
        } else {
            // before returning true make sure it's not for a demo user with editing disabled
            return $admin['is_demo']
                ? config('app.demo_admin_can_edit')
                : true;
        }
    }
}

if (! function_exists('createGate')) {
    /**
     * @param string $resourceClass
     * @param Admin|null $admin
     * @return void
     */
    function createGate(string $resourceClass, Admin|null $admin = null): void
    {
        if (!canCreate($resourceClass, $admin)) {

            if (App::environment('production')) {
                $message = 'Create not authorized.';
            } else {
                $resourceTypeName = strtolower(substr($resourceClass, strrpos("\\$resourceClass", '\\')));
                $message = 'Create not authorized for ' . $resourceTypeName;
                $message .= !empty($admin)
                    ? ' by admin ' . $admin['id'] . '.'
                    : '';
            }

            abort(403, $message);
        }
    }
}

if (! function_exists('readGate')) {
    /**
     * @param $resourceObject
     * @param Admin|null $admin
     * @return void
     */
    function readGate($resourceObject, Admin|null $admin = null): void
    {
        if (!canRead($resourceObject, $admin)) {

            if (App::environment('production')) {
                $message = 'Read not authorized.';
            } else {
                $class = get_class($resourceObject);
                $resourceTypeName = strtolower(substr($class, strrpos("\\$class", '\\')));
                $message = 'Read not authorized on ' . $resourceTypeName . ' ' . $resourceObject->id;
                $message .= !empty($admin)
                    ? ' by admin ' . $admin['id'] . '.'
                    : '';
            }

            abort(403, $message);
        }
    }
}

if (! function_exists('updateGate')) {
    /**
     * @param $resourceObject
     * @param Admin|null $admin
     * @return void
     */
    function updateGate($resourceObject, Admin|null $admin = null):void
    {
        if (!canUpdate($resourceObject, $admin)) {

            if (App::environment('production')) {
                $message = 'Update not authorized.';
            } else {
                $class = get_class($resourceObject);
                $resourceTypeName = strtolower(substr($class, strrpos("\\$class", '\\')));
                $message = 'Update not authorized on ' . $resourceTypeName . ' ' . $resourceObject->id;
                $message .= !empty($admin)
                    ? ' by admin ' . $admin['id'] . '.'
                    : '';
            }

            abort(403, $message);
        }
    }
}

if (! function_exists('deleteGate')) {
    /**
     * @param $resourceObject
     * @param Admin|null $admin
     * @return void
     */
    function deleteGate($resourceObject, Admin|null $admin = null): void
    {
        if (!canDelete($resourceObject, $admin)) {

            if (App::environment('production')) {
                $message = 'Delete not authorized.';
            } else {
                $class = get_class($resourceObject);
                $resourceTypeName = strtolower(substr($class, strrpos("\\$class", '\\')));
                $message = 'Delete not authorized on ' . $resourceTypeName . ' ' . $resourceObject->id;
                $message .= !empty($admin)
                    ? ' by admin ' . $admin['id'] . '.'
                    : '';
            }

            abort(403, $message);
        }
    }
}

if (! function_exists('formatCompensation')) {
    /**
     * Returns a formatted compensation.
     *
     * @param array $params
     * @return string
     */
    function formatCompensation(array $params = []): string
    {
        $symbol = !empty($params['symbol']) ? $params['symbol'] : '$';
        $min    = !empty($params['min']) ? $params['min'] : null;
        $max    = !empty($params['max']) ? $params['max'] : null;
        $unit   = !empty($params['unit']) ? $params['unit'] : null;
        $short  = isset($params['short']) && $params['short'];

        if ($short) {
            if (!empty($min)) {
                $min = ($min > 999) ? number_format(floor($min / 1000)) . 'k' : floor($min) . 'k';
            }
            if (!empty($max)) {
                $max = ($max > 999) ? number_format(floor($max / 1000)) . 'k' : floor($max) . 'k';
            }
        } else {
            $min = number_format($min);
            $max = number_format($max);
        }

        if (!empty($min) && !empty($max)) {
            $compensation = $symbol . $min . ' / ' . $symbol . $max . (!empty($unit) ? ' ' . $unit : '');
        } elseif (!empty($min)) {
            $compensation = $symbol . $min . (!empty($unit) ? ' ' . $unit : '');
        } elseif (!empty($max)) {
            $compensation = $symbol . $max . (!empty($unit) ? ' ' . $unit : '');
        } else {
            $compensation = '';
        }

        return $compensation;
    }
}

if (! function_exists('formatLocation')) {
    /**
     * Returns a formatted address.
     *
     * @param array $params
     * @return string
     */
    function formatLocation(array $params = []): string
    {
        $street          = !empty($params['street']) ? $params['street'] : null;
        $street2         = !empty($params['street2']) ? $params['street2'] : null;
        $city            = !empty($params['city']) ? $params['city'] : null;
        $state           = !empty($params['state']) ? $params['state'] : null;
        $zip             = !empty($params['zip']) ? $params['zip'] : null;
        $country         = !empty($params['country']) ? $params['country'] : null;
        $separator       = !empty($params['separator']) ? $params['separator'] : '<br>';
        $streetSeparator = !empty($params['streetSeparator']) ? $params['streetSeparator'] : ', ';

        if (!empty($street) && !empty($street2)) {
            $location = $street . $streetSeparator . $street2;
        } elseif (!empty($street)) {
            $location = $street;
        } elseif (!empty($street2)) {
            $location = $street2;
        } else {
            $location = '';
        }

        if (!empty($city) && !empty($state)) {
            $location .= (!empty($location) ? $separator : '') . $city . ', ' . $state;
        } elseif (!empty($city)) {
            $location .= (!empty($location) ? $separator : '') . $city;
        } elseif (!empty($state)) {
            $location .= (!empty($location) ? $separator : '') . $state;
        }

        if (!empty($zip)) {
            $location .= (!empty($location) ? ' ' : '') . $zip;
        }

        if (!empty($country)) {
            $location .= (!empty($location) ? $separator : '') . $country;
        }

        return $location;
    }
}

if (! function_exists('dateRangeDetails')) {
    /**
     * Returns an array of details about a date range.
     *
     * @param string $startDate
     * @param string|null $endDate
     * @param bool $shortFormat
     * @param bool $calculateDownToDays
     * @return array
     * @throws Exception
     */
    function dateRangeDetails(
        string $startDate,
        ?string $endDate = null,
        bool $shortFormat = true,
        bool $calculateDownToDays = true): array
    {
        // format start and end values
        $start = !empty($startDate)
            ? !$calculateDownToDays ? date("Y-m", strtotime($startDate)) : $startDate
            : null;
        $end = !empty($endDate)
            ? !$calculateDownToDays ? date("Y-m", strtotime($endDate)) : $endDate
        : null;

        $data = [
            'start'      => longDate($start, $shortFormat),
            'end'        => empty($end) ? 'Present' :  longDate($end, $shortFormat),
            'start_date' => $startDate,
            'end_date'   => $endDate,
        ];

        if (empty($data['end_date'])) {
            $data['end_date'] = date("Y-m-d");
        }

        $startDate = new DateTime($data['start_date']);
        $endDate = new DateTime($data['end_date']);

        $interval = $startDate->diff($endDate);
        $data['days'] = $interval->days;
        $data['months'] = ($interval->y * 12) + $interval->m;

        $parts = [];
        if (!empty($interval->y)) {
            $parts[] = $interval->y;
            $parts[] = ($interval->y > 1)
                ? ($shortFormat ? 'yrs' : 'years')
                : ($shortFormat ? 'yr' : 'year');
        }
        if (!empty($interval->m)) {
            $parts[] = $interval->m;
            $parts[] = ($interval->m > 1)
                ? ($shortFormat ? 'mos' : 'months')
                : ($shortFormat ? 'mo' : 'month');
        }
        if ($calculateDownToDays) {
            $parts[] = $interval->d;
            $parts[] = ($interval->d > 1)
                ? ($shortFormat ? 'dys' : 'days')
                : ($shortFormat ? 'dy' : 'day');
        }

        $data['range'] = implode(' ', $parts);

        return $data;
    }
}

if (! function_exists('imageUrl')) {
    /**
     * Returns the url of an image. If not a fully specifed url then the asset directory is used.
     *
     * @param string|null $source
     * @return string
     */
    function imageUrl(string|null $source): string
    {
        if (empty($source)) {
            return '';
        } elseif ('http://' === strtolower(substr($source, 0, 7))) {
            return $source;
        } elseif ('https://' === strtolower(substr($source, 0, 8))) {
            return $source;
        } else {
            if ($imageUrl = config('app.image_url')) {
                return $imageUrl . '/' . $source;
            } else {
                return asset($source);
            }
        }
    }
}

if (! function_exists('reservedKeywords')) {
    /**
     * Returns an array of reserved keywords that cannot be used for usernames, team names, etc.
     *
     * @return array
     */
    function reservedWords(): array
    {
        $reservedKeywords = array_unique(array_merge(
            [
                'about',
                'admin',
                'api',
                'captcha',
                'contact',
                'create',
                'database',
                'dashboard',
                'delete',
                'edit',
                'forgot username', 'forgot-username',
                'forgot password', 'forgot-password',
                'group',
                'index',
                'login',
                'logout',
                'other',
                'privacy policy', 'privacy-policy',
                'register',
                'resource',
                'root',
                'show',
                'storage',
                'team',
                'terms and conditions', 'terms-and-conditions',
                'up',
                'update',
                'user',
                'verify email', 'verify-email',
            ],
            Database::query()->select('name')->get()->pluck('name')->toArray(),
            Resource::query()->select('name')->get()->pluck('name')->toArray()
        ));

        sort($reservedKeywords);

        return $reservedKeywords;
    }

    if (! function_exists('isDemo')) {
        /**
         * Returns true if the site is in demo mode. Demo mode is set in the .env file
         * with the APP_DEMO setting.
         *
         * @return bool
         */
        function isDemo(): bool
        {
            if (!empty(config('app.demo_mode'))) {
                return true;
            } else {
                return false;
            }
        }
    }
}

if (! function_exists('uniqueSlug')) {
    /**
     * Returns a unique slug. If a table is specified the table must have a slug column.
     * If an ownerId is specified then it will make sure the slug is unique for that owner.
     * TODO: Come up with a nicer way of append characters to slug when needed to make it unique.
     *
     * @param string $name
     * @param string|null $table - For fully qualified table use dot "database.table" notation.
     * @param int|null $ownerId
     * @return string
     */
    function uniqueSlug(string $name, ?string $table = null, ?int $ownerId = null): string
    {
        $slug = \Illuminate\Support\Str::slug($name);

        if (!empty($table)) {

            if (str_contains($table, '.')) {
                $database = explode('.', $table)[0];
                $table = explode('.', $table)[1];
            } else {
                $database = null;
            }

            if (!empty($ownerId)) {

                if (empty($database)) {
                    while (DB::table($table)->where('owner_id', '=', $ownerId)
                        ->where('slug', '=', $slug)->count()
                    ) {
                        $slug = $slug . '-1';
                    }
                } else {
                    while (DB::connection($database)->table($table)->where('owner_id', '=', $ownerId)
                        ->where('slug', '=', $slug)->count()
                    ) {
                        $slug = $slug . '-1';
                    }
                }

            } else {

                if (empty($database)) {
                    while (DB::table($table)->where('slug', '=', $slug)->count()) {
                        $slug = $slug . '-1';
                    }
                } else {
                    while (DB::connection($database)->table($table)->where('slug', '=', $slug)->count()) {
                        $slug = $slug . '-1';
                    }
                }

            }
        }

        return $slug;
    }
}

if (! function_exists('themedTemplate')) {
    /**
     * If the specified template is found in the current theme directory then that is returned.
     * Otherwise, the specified theme is returned.
     *
     * @param string $template
     * @return string
     */
    function themedTemplate(string $template): string
    {
        if (!$theme = config('app.theme')) {
            return $template;
        }

        return View::exists('_themes.' . $theme . '.' . $template) ?
            '_themes.' . $theme . '.' . $template
            : $template;
    }
}

if (! function_exists('imageDir')) {
    /**
     * Returns the directory where images are stored.
     * @TODO: Add the ability to use S3 or remote locations.
     *
     * @return string
     */
    function imageDir(): string
    {
        return config('app.imageDir') ?? '';
    }
}

if (! function_exists('coverLetterDir')) {
    /**
     * Returns the directory where cover letters are stored.
     * @TODO: Add the ability to use S3 or remote locations.
     *
     * @return string
     */
    function coverLetterDir(): string
    {
        return config('app.coverLetterDir') ?? '';
    }
}

if (! function_exists('resumeDir')) {
    /**
     * Returns the directory where resumes are stored.
     * @TODO: Add the ability to use S3 or remote locations.
     *
     * @return string
     */
    function resumeDir(): string
    {
        return config('app.resumeDir') ?? '';
    }
}

if (! function_exists('generateEncodedFilename')) {
    /**
     * Generates a unique base64 encoded name for the file.
     * For extra security the Laravel application key is included.
     * @TODO: Add the ability to use S3 or remote locations.
     *
     * @param string $filename
     * @param string $qualifier
     * @param int $maxLength
     * @return string
     */
    function generateEncodedFilename(string $filename, string $qualifier = '', int $maxLength = 20): string
    {
        $text = substr($filename, 0, ceil($maxLength / 3))
            . substr($qualifier, 0, ceil($maxLength / 3))
            . config('app.key');

        $filename = rtrim(
            str_replace(
                ['+', '/'], ['-', '_'],
                base64_encode($text)
            ),
            '='
        );

        return substr($filename, 0, $maxLength);
    }
}

if (! function_exists('generateDownloadFilename')) {
    /**
     * Generates the file name for an image download.
     *
     * @param $resource
     * @param string|null $suffix
     * @return string
     */
    function generateDownloadFilename($resource, string|null $suffix = null): string
    {
        if (empty($resource)) {
            $filename = 'download';
        } elseif (is_string($resource)) {
            $filename = $resource;
        } else {
            if (!empty($resource->slug)) {
                $filename = $resource->slug;
            } elseif (!empty($resource->username)) {
                $filename = $resource->username;
            } elseif (!empty($resource->name)) {
                $filename = $resource->name;
            } elseif (!empty($resource->title)) {
                $filename = $resource->title;
            } else {
                $filename = 'download';
            }
        }

        if (!empty($suffix)) {
            $filename .= '-' . $suffix;
        }

        return Str::slug($filename);
    }
}

if (! function_exists('viewDocument')) {
    /**
     * Returns the route name of the refering page or null if there was no refering page.
     *
     * @param $filename
     * @return string|null
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    function viewDocument($filename): string|null
    {
        $filePath = base_path() . DIRECTORY_SEPARATOR . 'public'
            . DIRECTORY_SEPARATOR . 'portfolio'
            . DIRECTORY_SEPARATOR . 'images'
            . DIRECTORY_SEPARATOR . 'career'
            . DIRECTORY_SEPARATOR . 'resume'
            . DIRECTORY_SEPARATOR . '6'
            . DIRECTORY_SEPARATOR . 'NjIwMjUtMDdiYXNlNjQ6.docx';

        // Load the Word document
        $phpWord = IOFactory::createReader()->load($filePath);

        // Convert to HTML
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');

        // Save the HTML output to a variable or temporary file
        ob_start();
        $objWriter->save('php://output');
        $htmlContent = ob_get_contents();
        ob_end_clean();

        return view('document-display', compact('htmlContent'));
    }
}

if (! function_exists('calledFunction')) {
    /**
     * @return void
     */
    function calledFunction(): void
    {
        // Get the call stack
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

        // The first element [0] is the current function; the second element [1] is the caller
        $callerFunction = $trace[1]['function'] ?? 'N/A';
        $callerClass = $trace[1]['class'] ?? 'N/A';
        $callerLine = $trace[1]['line'] ?? 'N/A';
        $callerFile = $trace[1]['file'] ?? 'N/A';

        echo "Called by function: $callerFunction in class: $callerClass, file: $callerFile on line: $callerLine";
    }
}

if (! function_exists('calledFunction')) {
    /**
     * @return void
     */
    function callingFunction(): void
    {
        calledFunction();
    }
}

if (! function_exists('appTimestamp')) {
    /**
     * Returns the value of the APP_TIMESTAMP setting from the .env file which is appended as a parameter to urls
     * for JavaScript and CSS files to force the browser to reload them and not use the cache.
     *
     * @return string
     */
    function appTimestamp(): string
    {
        return config('app.app_timestamp');
    }
}

if (! function_exists('filteredPageTitle')) {
    /**
     * Returns a page title. If in the .env APP_SINGLE_ADMIN_MODE=1 then the $ownerName
     * is not added to the page title.
     *
     * @param string $pageType
     * @param string|null $ownerName
     * @return string
     */
    function filteredPageTitle(string $pageType,  string|null $ownerName = null): string
    {
        if (config('app.single_admin_mode') && !empty($ownerName)) {
            return ucfirst($pageType);
        } else {
            return $ownerName . ' ' . ucwords($pageType);
        }
    }
}

if (! function_exists('filteredBreadcrumbs')) {
    /**
     * If in the .env APP_SINGLE_ADMIN_MODE=1 then this filters our the "Candidates" and owner name breadcrumbs.
     *
     * @param array $breadcrumbs
     * @param Admin|Owner|null $owner
     * @return array
     */
    function filteredBreadcrumbs(array $breadcrumbs,  Admin|Owner|null $owner = null): array
    {
        if (empty($owner) || !config('app.single_admin_mode')) {
            return $breadcrumbs;
        }

        $filteredBreadcrumbs = [];
        foreach ($breadcrumbs as $breadcrumb) {
            if ($breadcrumb['name'] !== $owner['name'] && !in_array($breadcrumb['name'], ['Candidates', 'Admins'])) {
                $filteredBreadcrumbs[] = $breadcrumb;
            }
        }

        return $filteredBreadcrumbs;
    }
}

if (! function_exists('getShareImage')) {
    /**
     * Returns the url for the preview image file for a social network share or null if one does
     *
     * @param string $filename
     * @return string|null
     */
    function getShareImage(string $filename = 'default.png'): string|null
    {
        $imageFile = base_path()
            . DIRECTORY_SEPARATOR . 'public'
            . DIRECTORY_SEPARATOR . 'images'
            . DIRECTORY_SEPARATOR . 'share-images'
            . DIRECTORY_SEPARATOR . $filename;

        if (!file_exists($imageFile)) {
            return null;
        } else {
            return rtrim(config('app.url'), '/') . '/images/share-images/' . $filename;
        }
    }
}

if (! function_exists('validateDemoAdminCredentials')) {
    /**
     * Checks oto make sure that the admin specified by the APP_DEMO_ADMIN_USERNAME variable in the .env exists
     * in the database and has the password specified by APP_DEMO_ADMIN_PASSWORD matches.
     *
     * If the demo admin credentials specified in the .env are correct then boolean true is returned. Otherwise,
     * it returns an error message.
     *
     * @return bool|string
     */
    function validateDemoAdminCredentials(): bool|string
    {
        $errorMessage = '';
        if (!$username = config('app.demo_admin_username')) {
            $errorMessage = 'No APP_DEMO_ADMIN_USERNAME specified in .env file.';
        } elseif (!$password = config('app.demo_admin_password')) {
            $errorMessage = 'No APP_DEMO_ADMIN_PASSWORD specified in .env file.';
        } elseif(!$admin = Admin::query()->where('username', $username)->first()) {
            $errorMessage = 'Admin "' . $username . '"  specified by APP_DEMO_ADMIN_USERNAME in .env file not found in the database.';
        } else {
            if (Auth::guard('admin')->attempt([ 'username' => $username, 'password' => $password ])) {
                if ($admin->disabled) {
                    $errorMessage = 'The demo admin account "' . $username . '" has been disabled.';
                }
            } else {
                $errorMessage = 'The password specified by APP_DEMO_ADMIN_PASSWORD in .env file does not match the value in the database.';
            }
        }

        return !empty($errorMessage) ? $errorMessage : true;
    }
}

if (! function_exists('validateDemoUserCredentials')) {
    /**
     * Checks oto make sure that the admin specified by the APP_DEMO_ADMIN_USERNAME variable in the .env exists
     * in the database and has the password specified by APP_DEMO_ADMIN_PASSWORD matches.
     *
     * If the demo admin credentials specified in the .env are correct then boolean true is returned. Otherwise,
     * it returns an error message.
     *
     * @return bool|string
     */
    function validateDemoUserCredentials(): bool|string
    {
        $errorMessage = '';
        if (!$username = config('app.demo_user_username')) {
            $errorMessage = 'No APP_DEMO_USER_USERNAME specified in .env file.';
        } elseif (!$password = config('app.demo_user_password')) {
            $errorMessage = 'No APP_DEMO_USER_PASSWORD specified in .env file.';
        } elseif(!$user = User::query()->where('username', $username)->first()) {
            $errorMessage = 'User "' . $username . '"  specified by APP_DEMO_USER_USERNAME in .env file not found in the database.';
        } else {
            if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $password])) {
                if ($user->disabled) {
                    $errorMessage = 'The demo user account "' . $username . '" has been disabled.';
                }
            } else {
                $errorMessage = 'The password specified by APP_DEMO_USER_PASSWORD in .env file does not match the value in the database.';
            }
        }

        return !empty($errorMessage) ? $errorMessage : true;
    }
}

if (! function_exists('calculateWageRate')) {
    /**
     * Checks oto make sure that the admin specified by the APP_DEMO_ADMIN_USERNAME variable in the .env exists
     * in the database and has the password specified by APP_DEMO_ADMIN_PASSWORD matches.
     *
     * Returns the wage rate as dollars / hour from the average of the maximum and minimum compensation
     * and interval.
     *
     * @param float|null $minCompensation
     * @param float|null $maxCompensation
     * @param string|null $interval
     * @param int $estimatedHours
     * @return float|null
     */
    function calculateWageRate(
        float|null  $minCompensation,
        float|null  $maxCompensation,
        string|null $interval,
        int         $estimatedHours = 0
    ): float|null
    {
        $wageRate = null;

        if (!empty($minCompensation) || !empty($maxCompensation)) {

            if (!empty($minCompensation) && !empty($maxCompensation)) {
                $wage = ($minCompensation + $maxCompensation) / 2;
            } elseif (!empty($minCompensation)) {
                $wage = $minCompensation;
            } else {
                $wage = $maxCompensation;
            }

            switch ($interval) {
                case 'year':
                    $wageRate = round($wage / 2080);
                    break;
                case 'month':
                    $wageRate = round($wage / 173);
                    break;
                case 'week':
                    $wageRate = round($wage / 40);
                    break;
                case 'day':
                    $wageRate = round($wage / 8, 1);
                    break;
                case 'project':
                    if (!empty($estimatedHours)) {
                        $wageRate = $wage / $estimatedHours;
                    } else {
                        // if we don't have estimated hours for a project the just set wage rate is just the total compensation
                        $wageRate = $wage;
                    }
                    break;
                default:
                    $wageRate = $wage;
                    break;
            };
        }

        return $wageRate;
    }
}
