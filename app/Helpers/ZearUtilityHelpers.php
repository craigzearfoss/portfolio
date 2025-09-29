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
        return Auth::guard('user')->check();
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
        return Auth::guard('admin')->check();
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
        return (bool) Auth::guard('admin')->user()->root;
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
            $location .= (!empty($location) ? ', ' : '') . $country;
        }

        return $location;
    }
}


if (! function_exists('getFileSlug')) {
    /**
     * Returns a formatted address.
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

if (! function_exists('imageUrl')) {
    /**
     * Returns the url of the refering page or the specified fallback route if there was no referer.
     *
     * @param string | null $source
     * @return string
     */
    function imageUrl(string|null $source): string
    {
        if (empty($source)) {
            return '';
        } elseif ('http' === strtolower(substr($source, 0, 4))) {
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
            \App\Models\Database::select('name')->get()->pluck('name')->toArray(),
            \App\Models\Resource::select('name')->get()->pluck('name')->toArray()
        ));

        sort($reservedKeywords);

        return $reservedKeywords;
    }
}
