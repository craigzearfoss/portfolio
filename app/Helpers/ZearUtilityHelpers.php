<?php

if (! function_exists('refererRouteName')) {
    /**
     * Convert a Y-m-d MySQL formatted date to an m-d-Y formatted date.
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
     * Convert a Y-m-d MySQL formatted date to an m-d-Y formatted date.
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

