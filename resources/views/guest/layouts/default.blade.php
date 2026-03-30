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

    <div style="display: none;">
        <h1 class="title">Hello World!</h1>
        <img src="{{ config('app.url') }}/images/share-images/facebook-demo.zearfoss.com.png" alt="{{ config('app.name') }} preview image">
    </div>

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
                    'menuService' => $menuService,
                    'admin'       => $admin,
                    'user'        => $user,
                    'owner'       => $owner,
                ])

            </div>
        </div>

        @include('guest.components.title-bar', [
            'title'       => $title,
            'breadcrumbs' => filteredBreadcrumbs($breadcrumbs, $owner)
        ])

        @include('guest.components.subtitle-bar', [
            'title'      => $subtitle,
            'selectList' => $navSelectList,
            'buttons'    => $navButtons,
            'prev'       => $prev,
            'next'       => $next,
        ])

        <section class="is-main-section">

            @include('guest.components.messages', [
                'errorMessages' => $errorMessages,
                'success'       => $success,
                'error'         => $error,
            ])

            <div class="container">
                @yield('content')
            </div>

        </section>

        @php /* Social media links. */ @endphp
        @include('guest.components.social-media-share-links', [ 'page' => url()->current() ])

        @include('guest.components.footer')

    </div>

    <script src="{{ asset('assets/js/main.js') }}?{{ appTimestamp() }}"></script>

    {!! CookieConsent::scripts() !!}

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/share.js') }}"></script>

</body>

</html>
