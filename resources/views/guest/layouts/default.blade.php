@php
    // get error messages
    $errors = $errors ?? false;
    $errorMessages = [];
    if (empty(!$errors)) {
        $errorMessages = $errors->get('GLOBAL');
        if (empty($errorMessages) && ($errors->any() ?? false)) {
            $errorMessages[] = 'Fix the indicated errors before saving.';
        }
    }

    $title         = $title ?? '';
    $subtitle      = $subtitle ?? false;
    $breadcrumbs   = $breadcrumbs ?? [];
    $navButtons    = $navButtons ?? [];
    $navSelectList = $navSelectList ?? null;
    $prev          = $prev ?? null;
    $next          = $next ?? null;
    $success       = $success ?? session('success') ?? null;
    $error         = $error ?? session('error') ?? null;
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

        <?php /* For social media share links (@TODO: is this really needed?) */?>
        @if((Route::currentRouteName() == 'guest.index') && !config('app.single_admin_mode'))
            @include('guest.components.share-links', [ 'preview_image' => 'default.png' ])
        @endif

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
            'breadcrumbs' => $breadcrumbs,
            'navButtons'  => $navButtons,
            'prev'        => $prev,
            'next'        => $next,
        ])

        @include('guest.components.subtitle-bar', [
            'title'      => $subtitle,
            'selectList' => $navSelectList,
        ])

        <section class="is-main-section">

            @include('guest.components.messages', [
                'errorMessages' => $errorMessages,
                'success'       => $success,
                'error'         => $error,
            ])

            <div class="container m-0">
                @yield('content')
            </div>

        </section>

        <?php /* Social media share links */ ?>
        @include('guest.components.social-media-share-links', [ 'page' => url()->current() ])

        @include('guest.components.footer')

    </div>

    <script src="{{ asset('assets/js/main.js') }}?{{ appTimestamp() }}"></script>

    {!! CookieConsent::scripts() !!}

    <?php /* The following JavaScript files are need for the social-media-share links. */ ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/share.js') }}"></script>

</body>

</html>
