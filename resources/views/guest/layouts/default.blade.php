<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('guest.components.head')

<body>

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
