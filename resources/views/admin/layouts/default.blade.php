@php
    $currentRouteName = $currentRouteName ?? null;
    $loggedInAdmin    = $loggedInAdmin ?? null;
    $loggedInUser     = $loggedInUser ?? null;
    $admin            = $admin ?? null;
    $user             = $user ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('admin.components.head')

<body>

<?php /*
<div class="top-pinned-message has-background-grey-light has-text-grey-dark">
    Message pinned to the top of the browser window.
</div>
*/ ?>

<div id="app">

    @include('admin.components.nav-top', ['admin' => $admin ?? null])

    @include('admin.components.nav-left')

    @include('admin.components.title-bar', [
        'title'       => $title ?? '',
        'breadcrumbs' => $breadcrumbs ?? []
    ])

    @include('admin.components.subtitle-bar', [
        'title'      => $title ?? '',
        'selectList' => $selectList ?? '',
        'buttons'    => $buttons ?? [],
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

</body>

</html>
