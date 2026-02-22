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

        @include('admin.components.nav-top', [
            'menuService'      => $menuService,
            'admin'            => $admin,
            'user'             => $user,
            'owner'            => $owner,
        ])

        @include('admin.components.nav-left', [
            'menuService'      => $menuService,
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
            'selectList' => $navSelectList ?? '',
            'buttons'    => $navButtons,
        ])

        <section class="is-main-section">

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
