<?php

if (! function_exists('refererRouteName')) {
    /**
     * Returns the route name of the refering page or null if there was no refering page.
     *
     * @return string | null
     */
    function refererRouteName(): string | null
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
     * @param string | null $fallbackRoute
     * @param mixed $parameters
     * @param bool $absolute
     * @return string | null
     */
    function referer(string | null $fallbackRoute = null, mixed $parameters = [], bool $absolute = true): string | null
    {
        $referer = Request::input('referer') ?? (Request::header('referer') ?? null);
        $refererRouteName = refererRouteName();
        //dd([$referer, $refererRouteName]);

        if (empty($referer) && ! empty($fallbackRoute)) {
            try {
                $referer = route($fallbackRoute, $parameters, $absolute);
            } catch (\Throwable $th) {
            }
        }

        return $referer;
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
     * @param string | null $source
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
            return asset($source);
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
            return (bool) config('app.demo', false);
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
}
