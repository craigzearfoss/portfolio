@php
    $title         = $title ?? '';
    $subtitle      = $subtitle ?? false;
    $breadcrumbs   = $breadcrumbs ?? [];
    $navButtons    = $navButtons ?? [];
    $navSelectList = $navSelectList ?? null;
    $prev          = $prev ?? null;
    $next          = $next ?? null;
    $errorMessages = $errorMessages = [];
    $success       = $success ?? null;
    $error         = $error ?? null;
    $menuService   = $menuService ?? null;
    $admin         = $admin ?? null;
    $user          = $user ?? null;
    $owner         = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('guest.components.head')

<body>

    <div id="app">

        @include('guest.components.nav-top', [
            'menuService' => $menuService,
            'admin'       => $admin,
            'user'        => $user,
            'owner'       => $owner,
        ])

        @include('guest.components.nav-left', [
            'menuService' => $menuService,
            'admin'       => $admin,
            'user'        => $user,
            'owner'       => $owner,
        ])

        <div class="hamburger-nav">
            <div id="hamburger-menu-container">

                @include('guest.components.partials.left-menu-contents', [
                    'menuService' => $menuService ?? null,
                    'admin'       => $admin ?? null,
                    'user'        => $user ?? null,
                    'owner'       => $owner ?? null,
                ])

            </div>
        </div>

        @include('guest.components.title-bar', [
            'title'       => $title ?? '',
            'breadcrumbs' => $breadcrumbs ?? []
        ])

        @include('guest.components.subtitle-bar', [
            'title'      => $subtitle ?? '',
            'selectList' => $navSelectList ?? '',
            'buttons'    => $navButtons ?? [],
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

    <script src="{{ asset('assets/js/main.js') }}?{{ appTimestamp() }}"></script>

    {!! CookieConsent::scripts() !!}

</body>

</html>
