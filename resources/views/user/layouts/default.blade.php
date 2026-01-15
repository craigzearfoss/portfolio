@php
    $currentRouteName = $currentRouteName ?? null;
    $loggedInAdmin    = $loggedInAdmin ?? null;
    $loggedInUser     = $loggedInUser ?? null;
    $admin            = $admin ?? null;
    $user             = $user ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('user.components.head')

<body>

<div id="app">

    @include('user.components.nav-top')

    @include('user.components.nav-left')

    @include('user.components.title-bar', [
        'title'       => $title ?? '#title#',
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

</body>

</html>
