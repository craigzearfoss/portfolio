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
    $errorMessages = $errorMessages = [];
    $success       = $success ?? session('success') ?? null;
    $error         = $error ?? session('error') ?? null;
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

        <?php /* For social media share links (@TODO: is this really needed?) */?>
        <?php /*
        @if((Route::currentRouteName() == 'guest.index') && !config('app.single_admin_mode'))
            @include('admin.components.share-links', [ 'preview_image' => 'default.png' ])
        @endif
        */ ?>

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

        @include('admin.components.title-bar', [
            'title'       => $title,
            'breadcrumbs' => $breadcrumbs,
            'navButtons'  => $navButtons,
            'prev'        => $prev,
            'next'        => $next,
        ])

        @include('admin.components.subtitle-bar', [
            'title'      => $subtitle,
            'selectList' => $navSelectList,
        ])

        <section class="is-main-section">

            @include('admin.components.messages', [
                'errorMessages' => $errorMessages,
                'success'       => $success,
                'error'         => $error,
            ])

            <div class="container m-0">
                @yield('content')
            </div>

        </section>

        <?php /* Social media share links */ ?>
        <?php /*
        @include('admin.components.social-media-share-links', [ 'page' => url()->current() ])
	*/ ?>

        @include('admin.components.footer')

    </div>

    <script src="{{ asset('assets/js/main.js') }}?{{ appTimestamp() }}"></script>

    {!! CookieConsent::scripts() !!}

    <?php /* The following JavaScript files are need for the social-media-share links. */ ?>
    <?php /*
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/share.js') }}"></script>
    */ ?>

</body>

</html>
