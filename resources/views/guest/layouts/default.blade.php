@php
    $title            = $title ?? '';
    $subtitle         = $subtitle ?? false;
    $breadcrumbs      = $breadcrumbs ?? [];
    $buttons          = $buttons ?? [];
    $errorMessages    = $errorMessages = [];
    $success          = $success ?? null;
    $error            = $error ?? null;
    $menuService      = $menuService ?? null;
    $admin            = $admin ?? null;
    $user             = $user ?? null;
    $owner            = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('guest.components.head')

<body>

    <div id="app">

        @include('guest.components.nav-top', [
            'menuService' => $menuService ?? null,
            'admin'       => $admin ?? null,
            'user'        => $user ?? null,
            'owner'       => $owner ?? null,
        ])

        @include('guest.components.nav-left', [
            'menuService' => $menuService ?? null,
            'admin'       => $admin ?? null,
            'user'        => $user ?? null,
            'owner'       => $owner ?? null,
        ])

        @include('guest.components.title-bar', [
            'title'       => $title ?? '',
            'breadcrumbs' => $breadcrumbs ?? []
        ])

        @include('guest.components.subtitle-bar', [
            'title'      => $title ?? '',
            'selectList' => $selectList ?? '',
            'buttons'    => $buttons ?? [],
            'prev'       => $prev ?? null,
            'next'       => $next ?? null,
        ])

        <section class="is-main-section">

            @include('guest.components.messages', [
                'errorMessages' => $errorMessages ?? [],
                'success'       => $success ?? null,
                'error'         => $error ?? null,
            ])

            <div class="container">
                @yield('content')
            </div>

        </section>

        @include('guest.components.footer')

    </div>

    {!! CookieConsent::scripts() !!}

</body>

</html>
