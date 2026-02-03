<?php

use App\Models\System\Admin;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;

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
        } catch (\Throwable $th) {
            $routeName = null;
        }

        return $routeName;
    }
}

if (! function_exists('adminRoute')) {
    /**
     * Returns the route name of the refering page or null if there was no refering page.
     *
     * @param BackedEnum|string $name
     * @param mixed $params
     * @param \App\Models\System\Admin|null $admin
     * @param \App\Models\System\Admin|null $owner
     * @param $resource
     * @param bool $absolute
     * @return string|null
     */
    function adminRoute(BackedEnum|string $name,
                        mixed $params = [],
                        $resource = null,
                        \App\Models\System\Admin|null $owner = null,
                        bool $absolute = true): string|null
    {
        if (explode('.', $name)[0] === 'root') {
die('ddd');
            if (!empty($resource) && $resource->has_owner) {
                $params = is_array($params)
                    ? array_merge($params, [$owner])
                    : array_merge([$params], [$owner]);
                dd([$name, $params, $owner]);
            }

            $route = route($name, $params, $absolute);

        } else {

            $route = route($name, $params, $absolute);
        }

        return $route;

        return route($name, $params, $absolute);
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
            } catch (\Throwable $th) {
            }
        }

        return $referer;
    }
}

if (! function_exists('loggedInUser')) {
    /**
     * Returns User object of the logged-in user or null if there is not one.
     *
     * @return \App\Models\System\Admin|null
     */
    function loggedInUser(): \App\Models\System\Admin|null
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
        } catch (\Throwable $th) {
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
        } catch (\Throwable $th) {
            return false;
        }
    }
}

if (! function_exists('loggedInAdmin')) {
    /**
     * Returns Admin object of the logged-in admin or null if there is not one.
     *
     * @return \App\Models\System\Admin|null
     */
    function loggedInAdmin(): \App\Models\System\Admin|null
    {
        if (! Auth::guard('admin')->check()) {
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
        } catch (\Throwable $th) {
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
        } catch (\Throwable $th) {
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
            return Auth::guard('admin')->check() && (bool)Auth::guard('admin')->user()->root;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

if (! function_exists('canCreate')) {

    /**
     * Returns true if an admin can create a resource.
     * Parameter #1, $resource, must be the name of a resource type.
     *
     * @param $resource
     * @param Admin|null $admin
     * @return bool
     */
    function canCreate($resource, \App\Models\System\Admin|null $admin = null): bool
    {
        if (empty($resource)) {
            abort(500, 'canCreate(): Argument #1 ($resource) cannot be empty');
        } elseif (empty($admin)) {
            return false;
        } elseif (!empty($admin->root)) {
            return true;
        } else {
            if (!is_string($resource)) {
                abort(500, 'canCreate(): Argument #1 ($resource) must be the name of a resource type');
            }

            if (!$resourceType = \App\Models\System\Resource::where('name', $resource)->first()) {
                return false;
            } else {
                // non-root admins can only create resources that have an owner_id column
                return isset($resourceType->owner_id);
            }
        }
    }
}

if (! function_exists('canDelete')) {

    /**
     * Returns true if an admin can delete a resource.
     * Parameter #1, $resource, must be a resource object.
     *
     * @param $resource
     * @param Admin|null $admin
     * @return bool
     */
    function canDelete($resource, \App\Models\System\Admin|null $admin = null): bool
    {
        if (empty($resource)) {
            abort(500, 'canDelete(): Argument #1 ($resource) cannot be empty');
        } elseif (empty($admin)) {
            return false;
        } elseif (!empty($admin->root)) {
            return true;
        } else {
            if (is_string($resource)) {
                abort(500, 'canDelete(): Argument #1 ($resource) must be a resource object');
            }

            // non-root admins can only delete resources that they own
            $resourceColumns = $resource->attributesToArray();
            if (!isset($resourceColumns['owner_id']) || ($resourceColumns['owner_id'] != $admin->id)) {
                return false;
            } else {
                return true;
            }
        }
    }
}

if (! function_exists('canRead')) {

    /**
     * Returns true if an admin can read a resource.
     * Parameter #1, $resource, must be a resource object or the name of a resource type.
     * @TODO: Note that this does not handle duplicate table names. Right now the only duplicates we have are "database".
     *
     * @param $resource
     * @param Admin|null $admin
     * @return bool
     */
    function canRead($resource, \App\Models\System\Admin|null $admin = null): bool
    {
        if (empty($resource)) {
            abort(500, 'canRead(): Argument #1 ($resource) cannot be empty');
        } elseif (empty($admin)) {
            return false;
        } elseif (!empty($admin->root)) {
            return true;
        } else {
            //@TODO: do we need to do any additional checking
            return true;
        }
    }
}

if (! function_exists('canUpdate')) {

    /**
     * Returns true if an admin can update a resource.
     * Parameter #1, $resource, must be a resource object.
     *
     * @param $resource
     * @param Admin|null $admin
     * @return bool
     */
    function canUpdate($resource, \App\Models\System\Admin|null $admin = null): bool
    {
        if (empty($resource)) {
            abort(500, 'canUpdate(): Argument #1 ($resource) cannot be empty');
        } elseif (empty($admin)) {
            return false;
        } elseif (!empty($admin->root)) {
            return true;
        } else {
            if (is_string($resource)) {
                abort(500, 'canUpdate(): Argument #1 ($resource) must be a resource object');
            }

            // non-root admins can only update resources that they own
            $resourceColumns = $resource->attributesToArray();
            if (!isset($resourceColumns['owner_id']) || ($resourceColumns['owner_id'] != $admin->id)) {
                return false;
            } else {
                return true;
            }
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
        $short  = isset($params['short']) && !is_null($params['short']) ? boolval($params['short']) : false;

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


if (! function_exists('getFileSlug')) {
    /**
     * Returns a 'sluggified' name with the specified file extension appended.
     *
     * @param string $name
     * @param string $ext
     * @return string
     */
    function getFileSlug($name, $ext = 'png'): string
    {
        $fileSlug = \Illuminate\Support\Str::slug($name);

        if (false !== strpos($ext,'.')) {
            $ext = pathinfo($ext, PATHINFO_EXTENSION);
        } else {
            $ext = '';
        }

        if (!empty($ext)) {
            $fileSlug = $fileSlug . '.' . $ext;
        }

        return $fileSlug;
    }
}

if (! function_exists('dateRangeDetails')) {
    /**
     * Returns an array of details about a date range.
     *
     * @param string $startDate
     * @param string|null $endDate
     * @param bool $shortFormat
     * @return array
     * @throws Exception
     */
    function dateRangeDetails(string $startDate, ?string $endDate = null, bool $shortFormat = true): array
    {
        $calculateDownToDays = true;

        $data = [
            'start'      => longDate($startDate, $shortFormat),
            'end'        => empty($endDate) ? 'Present' :  longDate($endDate, $shortFormat),
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'days'       => null,
            'months'     => null,
            'range'      => null,
        ];

        if (count(explode('-', $data['start_date'])) == 2) {
            // Assume the date only has a year and a month, but no day like 'Y-m'.
            $calculateDownToDays = false;
            $data['start_date'] .= '-01';
        }

        if (empty($data['end_date'])) {
            $data['end_date'] = date("Y-m-d");
        }
        if (count(explode('-', $data['end_date'])) == 2) {
            // Assume the date only has a year and a month, but no day like 'Y-m'.
            $data['end_date'] .= '-01';
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
     * Returns an array of reserved keywords that cannot be used for user names, team names, etc.
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
            \App\Models\System\Database::select('name')->get()->pluck('name')->toArray(),
            \App\Models\System\Resource::select('name')->get()->pluck('name')->toArray()
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
     * @param string|null $table
     * @param int|null $ownerId
     * @return string
     */
    function uniqueSlug(string $name, ?string $table = null, ?int $ownerId = null): string
    {
        $slug = \Illuminate\Support\Str::slug($name);

        if (!empty($table)) {

            if (strpos($table, '.') !== false) {
                $database = explode('.', $table)[0];
                $table = explode('.', $table)[1];
            } else {
                $database = null;
            }

            if (!empty($ownerId)) {

                if (empty($database)) {
                    while (DB::table($table)->where('owner_id', $ownerId)->where('slug', $slug)->count()) {
                        $slug = $slug . '-1';
                    }
                } else {
                    while (DB::connection($database)->table($table)->where('owner_id', $ownerId)->where('slug', $slug)->count()) {
                        $slug = $slug . '-1';
                    }
                }

            } else {

                if (empty($database)) {
                    while (DB::table($table)->where('slug', $slug)->count()) {
                        $slug = $slug . '-1';
                    }
                } else {
                    while (DB::connection($database)->table($table)->where('slug', $slug)->count()) {
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

        return View::exists('_themes.'.$theme.'.' . $template) ?
            '_themes.'.$theme.'.' . $template
            : $template;
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

    if (! function_exists('resourceRoute')) {
        /**
         * Returns the route for a resource.
         *
         * @param string $envType
         * @param string $databaseName
         * @param string|null $tableName
         * @param Admin|null $admin
         * @return string|null
         */
        function getResourceRouteName(string $envType,
                                      string $databaseName,
                                      string|null $tableName = null,
                                      \App\Models\System\Admin|null $admin = null): string|null
        {
            $routeParts   = [];
            $routeParts[] = $envType;

            $routeParts[] = $databaseName;
            if (!empty($tableName)) $routeParts[] = $tableName;
            $routeParts[] = 'index';

            $route = implode('.', $routeParts);

            if (!Route::has($route)) {
                $route = null;
            }

            return $route;
        }
    }

    if (! function_exists('adminResourceRouteName')) {
        /**
         * Returns an admin route by checking if it is for an admin with root privileges.
         */
        function adminResourceRouteName(string                                                       $databaseName,
                                        \App\Models\System\Resource|\App\Models\System\AdminResource $resource,
                                        string                                                       $action,
                                        string                                                       $envType = PermissionService::ENV_GUEST,
                                                                                                     $isRoot = false): string
        {
            //dd($resource);
            $envType = $isRoot ? 'root' : 'admin';

            $parts = [$envType];
            if ($databaseName != 'system') {
                $parts[] = $databaseName;
            }
            $parts[] = $resource->name;
            if (($envType == PermissionService::ENV_ADMIN) && $isRoot) {

            } else {
                $parts[] = $databaseName;
            }
            $parts[] = ($envType == PermissionService::ENV_ADMIN) && $isRoot
                ? $resource->id
                : (property_exists($resource, 'slug') ? $resource->slug : $resource->id);
            $parts[] = $action;
            dd($parts);
            $route = implode('.', $parts);

            // if the "root" route doesn't exist fallback to the "admin" route
            if (($envType == 'root') && !Route::has($route)) {
                array_shift($parts);
                $route = '.admin' . implode('.', $parts);
            }

            return $route;
        }
    }
}

if (! function_exists('viewDocument')) {
    /**
     * Returns the route name of the refering page or null if there was no refering page.
     *
     * @return string|null
     */
    function viewDocument($filename): string|null
    {
        $filePath = Storage::path('documents/' . $filename); // Adjust the path as needed

        $filePath = base_path() . DIRECTORY_SEPARATOR . 'public'
            . DIRECTORY_SEPARATOR . 'portfolio'
            . DIRECTORY_SEPARATOR . 'images'
            . DIRECTORY_SEPARATOR . 'career'
            . DIRECTORY_SEPARATOR . 'resume'
            . DIRECTORY_SEPARATOR . '6'
            . DIRECTORY_SEPARATOR . 'NjIwMjUtMDdiYXNlNjQ6.docx';

        // Load the Word document
        $phpWord = IOFactory::createReader('Word2007')->load($filePath);

        // Convert to HTML
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlContent = '';

        // Save the HTML output to a variable or temporary file
        ob_start();
        $objWriter->save('php://output');
        $htmlContent = ob_get_contents();
        ob_end_clean();

        return view('document-display', compact('htmlContent'));
    }
}
