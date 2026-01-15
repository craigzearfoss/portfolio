@php
    $currentRouteName = $currentRouteName ?? null;
    $loggedInAdmin    = $loggedInAdmin ?? null;
    $loggedInUser     = $loggedInUser ?? null;
    $admin            = $admin ?? null;
    $user             = $user ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('guest.components.head')

<body>

<?php /*
<div class="top-pinned-message has-background-grey-light has-text-grey-dark">
    Message pinned to the top of the browser window.
</div>
*/ ?>

<div id="app">

    @include('guest.components.nav-top')

    @include('guest.components.nav-left')

    @include('guest.components.title-bar', [
        'title'       => $title ?? '',
        'breadcrumbs' => $breadcrumbs ?? []
    ])

    @include('guest.components.subtitle-bar', [
        'title'      => $title ?? '',
        'selectList' => $selectList ?? '',
        'buttons'    => $buttons ?? [],
    ])

    <section class="is-main-section px-4 py-3">

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

</body>

</html>
