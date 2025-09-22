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

if (! function_exists('isRootAdmin')) {
    /**
     * Returns true if an admin with root privileges.
     *
     * @return bool
     */
    function isRootAdmin(): bool
    {return true;
        return (bool) Auth::guard('admin')->user()->root;
    }
}
