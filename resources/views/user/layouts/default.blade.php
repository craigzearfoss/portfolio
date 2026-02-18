@php
    $admin            = $admin ?? null;
    $user             = $user ?? null;
    $owner            = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('user.components.head')

<body>

    <div id="app">

        @include('user.components.nav-top', [
            'menuService'      => $menuService ?? null,
            'admin'            => $admin ?? null,
            'user'             => $user ?? null,
            'owner'            => $owner ?? null,
        ])

        @include('guest.components.nav-left', [
            'menuService'      => $menuService ?? null,
            'admin'            => $admin ?? null,
            'user'             => $user ?? null,
            'owner'            => $owner ?? null,
        ])

        @include('user.components.title-bar', [
            'title'       => $title ?? '',
            'breadcrumbs' => $breadcrumbs ?? []
        ])

        @include('user.components.subtitle-bar', [
            'title'      => $title ?? '',
            'selectList' => $selectList ?? '',
            'buttons'    => $buttons ?? [],
        ])

        <section class="is-main-section px-4 py-3">

            @include('user.components.messages', [
                'errorMessages' => $errorMessages ?? [],
                'success'       => $success ?? null,
                'error'         => $error ?? null,
            ])

            <div class="container">
                @yield('content')
            </div>

        </section>

        @include('user.components.footer')

    </div>

    {!! CookieConsent::scripts() !!}

</body>

</html>
