@php
    $title         = $title ?? '';
    $subtitle      = $subtitle ?? false;
    $breadcrumbs   = $breadcrumbs ?? [];
    $navButtons    = $navButtons ?? [];
    $navSelectList = $navSelectList ?? null;
    $prev          = $prev ?? null;
    $next          = $next ?? null;
    $errorMessages = $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [];
    //$errorMessages = $errorMessages = [];
    $success       = $success ?? null;
    $error         = $error ?? null;
    $menuService   = $menuService ?? null;
    $admin         = $admin ?? null;
    $user          = $user ?? null;
    $owner         = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('admin.components.head')

<body>

    <div id="app">

        <div style="display: none;">
            <h1 class="title">Hello World!</h1>
            <img src="{{ config('app.url') }}/images/share-images/facebook-demo.zearfoss.com.png" alt="{{ config('app.name') }} preview image">
        </div>

        @include('admin.components.nav-top', [
            'menuService' => $menuService,
            'admin'       => $admin,
            'user'        => $user,
            'owner'       => $owner,
        ])

        @include('admin.components.nav-left', [
            'menuService' => $menuService,
            'admin'       => $admin,
            'user'        => $user,
            'owner'       => $owner,
        ])

        <div class="hamburger-nav">
            <div id="hamburger-menu-container">

                @include('admin.components.partials.left-menu-contents', [
                    'menuService' => $menuService,
                    'admin'       => $admin,
                    'user'        => $user,
                    'owner'       => $owner,
                ])

            </div>
        </div>

        @include('guest.components.title-bar', [
            'title'       => $title,
            'breadcrumbs' => $breadcrumbs
        ])

        @include('admin.components.subtitle-bar', [
            'title'      => $subtitle,
            'selectList' => $navSelectList,
            'buttons'    => $navButtons,
            'prev'       => $prev,
            'next'       => $next,
        ])

        <section class="is-main-section">

            @include('admin.components.messages', [
                'errorMessages' => $errorMessages,
                'success'       => $success,
                'error'         => $error,
            ])

            <div class="container">
                @yield('content')
            </div>

        </section>

        @include('admin.components.footer')

    </div>

    <script src="{{ asset('assets/js/main.js') }}?{{ appTimestamp() }}"></script>

    {!! CookieConsent::scripts() !!}

</body>

</html>
