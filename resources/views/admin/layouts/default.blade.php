@php
    $title            = $title ?? '';
    $breadcrumbs      = $breadcrumbs ?? [];
    $buttons          = $buttons ?? [];
    $errorMessages    = $errorMessages = [];
    $success          = $success ?? null;
    $error            = $error ?? null;
    $menuService      = $menuService ?? null;
    $currentRouteName = $currentRouteName ?? Route::currentRouteName();
    $admin            = $admin ?? null;
    $user             = $user ?? null;
    $owner            = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('admin.components.head')

<body>

    <div id="app">

        @include('admin.components.nav-top', [
            'menuService'      => $menuService,
            'currentRouteName' => $currentRouteName,
            'admin'            => $admin,
            'user'             => $user,
            'owner'            => $owner,
            ''
        ])

        @include('admin.components.nav-left', [
            'menuService'      => $menuService,
            'currentRouteName' => $currentRouteName,
            'admin'            => $admin,
            'user'             => $user,
            'owner'            => $owner,
        ])

        @include('admin.components.title-bar', [
            'title'       => $title,
            'breadcrumbs' => $breadcrumbs ?? []
        ])

        @include('admin.components.subtitle-bar', [
            'title'      => $title,
            'selectList' => $selectList ?? '',
            'buttons'    => $buttons,
        ])

        <section class="is-main-section px-4 py-3">

            @include('admin.components.messages', [
                'errorMessages' => $errorMessages ?? [],
                'success'       => $success ?? null,
                'error'         => $error ?? null,
            ])

            <div class="container">
                @yield('content')
            </div>

        </section>

        @include('admin.components.footer')

    </div>

    {!! CookieConsent::scripts() !!}

</body>

</html>
