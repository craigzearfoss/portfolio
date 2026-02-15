<?php

use App\Enums\EnvTypes;
use App\Enums\PermissionEntityTypes;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;

if (! function_exists('getEnvType')) {
    /**
     * Determines the environment from the current route name.
     *
     * @return EnvTypes
     */
    function getEnvType()
    {
        $currentRoute = Route::currentRouteName();
        switch (!empty($currentRoute) ? explode('.', $currentRoute)[0] : '') {
            case 'admin':
                $envType = EnvTypes::ADMIN;
                break;
            case 'user':
                $envType = EnvTypes::USER;
                break;
            case 'guest':
            default:
                $envType = EnvTypes::GUEST;
                break;
        }

        return $envType;
    }
}

if (! function_exists('dbName')) {
    /**
     * Returns the name of a database when give a database tag.
     *
     * @param string $dbTag
     * @return string|null
     */
    function dbName(string $dbTag) {
        if ($database = Database::where('tag', 'career_db')->first()) {
            return $database->name;
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
        } catch (\Throwable $th) {
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
     * Returns true if an admin can create an entity.
     * Parameter #2, $entity, must be the name of an entity (ex. database or resource).
     *
     * @param \App\Enums\PermissionEntityTypes|string $entityType
     * @param string $entity
     * @param Admin|null $admin
     * @return bool
     */
    function canCreate(\App\Enums\PermissionEntityTypes|string $entityType,
                       string $entity,
                       \App\Models\System\Admin|null $admin = null): bool
    {
        if (empty($entity)) {
            abort(500, 'canCreate(): Argument #2 ($entity) cannot be empty');
        } elseif (empty($admin)) {
            return false;
        } elseif (!empty($admin->root)) {
            return true;
        } else {

            if ($entityType === \App\Enums\PermissionEntityTypes::DATABASE) {
                $entity = \App\Models\System\AdminDatabase::where('name', $entity)->first();
            } else {
                $entity = \App\Models\System\AdminResource::where('name', $entity)->first();
            }

            // non-root admins cannot create root entities
            if(empty($entity) || !empty($entity->root)) {
                return false;
            } else {
                return true;
            }
        }
    }
}

if (! function_exists('canRead')) {

    /**
     * Returns true if an admin can read an entity.
     * Parameter #2, $entity, must be an entity object or the name of an entity type.
     * @TODO: Note that we allow admins to read other admin's entities. We should probably implement a RBAC system.
     * @TODO: Note that this does not handle duplicate table names. Right now the only duplicates we have are "database".
     *
     * @param \App\Enums\PermissionEntityTypes|string $entityType
     * @param $entity
     * @param Admin|null $admin
     * @return bool
     */
    function canRead(\App\Enums\PermissionEntityTypes|string $entityType,
                     $entity, \App\Models\System\Admin|null
                     $admin = null): bool
    {
        if (empty($entity)) {
            abort(500, 'canRead(): Argument #2 ($entity) cannot be empty.');
        } elseif (empty($admin)) {
            return false;
        } elseif (!empty($admin->root)) {
            return true;
        } else {

            if (is_string($entity)) {
                if ($entityType === \App\Enums\PermissionEntityTypes::DATABASE) {
                    $entity = \App\Models\System\AdminDatabase::where('owner_id', $admin->id)
                        ->where('name', $entity)->first();
                } else {
                    $entity = \App\Models\System\AdminResource::where('owner_id', $admin->id)
                        ->where('name', $entity)->first();
                }
            }

            // non-root admins cannot read root entities
            if(empty($entity) || !empty($entity->root)) {
                return false;
            } else {
                return true;
            }
        }
    }
}

if (! function_exists('canUpdate')) {

    /**
     * Returns true if an admin can update an entity.
     * Only root admins can update entities that belong to other admins.
     * * Parameter #2, $entity, must be an entity object.
     *
     * @param \App\Enums\PermissionEntityTypes $entityType
     * @param $entity
     * @param Admin|null $admin
     * @return bool
     */
    function canUpdate(\App\Enums\PermissionEntityTypes $entityType,
                       $entity,
                       \App\Models\System\Admin|null $admin = null): bool
    {
        if (empty($entity)) {
            abort(500, 'canUpdate(): Argument #2 ($entity) cannot be empty');
        } elseif (empty($admin)) {
            return false;
        } elseif (!empty($admin->root)) {
            return true;
        } else {

            if (!is_string($entity)) {
                if (!$table = $entity->getTable()) {
                    abort(500, 'canUpdate(): Table not found in Argument #2 ($entity). ' . callingFunction());
                } elseif (!$adminResourceRow = AdminResource::where('table', $table)->first()) {
                    abort(500, 'canUpdate(): Resource not found for table ' . $table . '. ' . callingFunction());
                }
            }

            // non-root admins can only update entities that they own
            $entityColumns = $entity->attributesToArray();
            if (!isset($entityColumns['owner_id']) || ($entityColumns['owner_id'] != $admin->id)) {
                return false;
            } else {
                return true;
            }
        }
    }
}

if (! function_exists('canDelete')) {

    /**
     * Returns true if an admin can delete an entity.
     * Only root admins can delete entities that belong to other admins.
     * Parameter #2, $entity, must be an entity object.
     *
     * @param \App\Enums\PermissionEntityTypes $entityType
     * @param $entity
     * @param Admin|null $admin
     * @return bool
     */
    function canDelete(\App\Enums\PermissionEntityTypes $entityType,
                       $entity,
                       \App\Models\System\Admin|null $admin = null): bool
    {
        if (empty($entity)) {
            abort(500, 'canDelete(): Argument #2 ($entity) cannot be empty.');
        } elseif (empty($admin)) {
            return false;
        } elseif (!empty($admin->root)) {
            return true;
        } else {

            if (!$table = $entity->getTable()) {
                abort(500, 'canDelete(): Table not found in Argument #2 ($entity). ' . callingFunction());
            } elseif (!$adminResourceRow = AdminResource::where('table', $table)->first()) {
                abort(500, 'canDelete(): Resource not found for table ' . $table . '. ' . callingFunction());
            }

            // non-root admins can only delete entities that they own
            $entityColumns = $entity->attributesToArray();
            if (!isset($entityColumns['owner_id']) || ($entityColumns['owner_id'] != $admin->id)) {
                return false;
            } else {
                return true;
            }
        }
    }
}

if (! function_exists('createGate')) {
    /**
     * @param \App\Enums\PermissionEntityTypes|string $entityType
     * @param string $entity
     * @param Admin|null $admin
     * @return void
     */
    function createGate(\App\Enums\PermissionEntityTypes|string $entityType,
                        string                                  $entity,
                        \App\Models\System\Admin|null           $admin = null)
    {
        if (!canCreate($entityType, $entity, $admin)) {
            abort(403, 'Read not authorized.');
        }
    }
}

if (! function_exists('readGate')) {
    /**
     * @param \App\Enums\PermissionEntityTypes|string $entityType
     * @param $entity
     * @param Admin|null $admin
     * @return void
     */
    function readGate(\App\Enums\PermissionEntityTypes|string $entityType,
                      $entity,
                      \App\Models\System\Admin|null $admin = null)
    {
        if (!canRead($entityType, $entity, $admin)) {
            abort(403, 'Read not authorized.');
        }
    }
}

if (! function_exists('updateGate')) {
    /**
     * @param \App\Enums\PermissionEntityTypes $entityType
     * @param $entity
     * @param Admin|null $admin
     * @return void
     */
    function updateGate(\App\Enums\PermissionEntityTypes $entityType,
                        $entity,
                        \App\Models\System\Admin|null $admin = null)
    {
        if (!canUpdate($entityType, $entity, $admin)) {
            abort(403, 'Update not authorized.');
        }
    }
}

if (! function_exists('deleteGate')) {
    /**
     * @param \App\Enums\PermissionEntityTypes $entityType
     * @param $entity
     * @param Admin|null $admin
     * @return void
     */
    function deleteGate(\App\Enums\PermissionEntityTypes $entityType,
                        $entity,
                        \App\Models\System\Admin|null $admin = null)
    {
        if (!canDelete($entityType, $entity, $admin)) {
            abort(403, 'Delete not authorized.');
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
        $short  = isset($params['short']) && boolval($params['short']);

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
    function getFileSlug(string $name, string $ext = 'png'): string
    {
        $fileSlug = \Illuminate\Support\Str::slug($name);

        if (false !== str_contains($ext,'.')) {
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

            if (str_contains($table, '.')) {
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
        $filePath = Storage::path('documents/' . $filename); // Adjust the path as needed

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
        $htmlContent = '';

        // Save the HTML output to a variable or temporary file
        ob_start();
        $objWriter->save('php://output');
        $htmlContent = ob_get_contents();
        ob_end_clean();

        return view('document-display', compact('htmlContent'));
    }
}

if (! function_exists('calledFunction')) {
    function calledFunction()
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
    function callingFunction()
    {
        calledFunction();
    }
}
