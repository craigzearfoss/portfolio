<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('front.components.head')

<body>

<div id="app">

    @include('front.components.nav-top')

    @include('front.components.nav-left')

    @include('front.components.title-bar', [
        'title'       => $title ?? '',
        'breadcrumbs' => $breadcrumbs ?? []
    ])

    @include('front.components.subtitle-bar', [
        'title'      => $title ?? '',
        'selectList' => $selectList ?? '',
        'buttons'    => $buttons ?? [],
    ])

    <section class="is-main-section px-4 py-3">

        @include('front.components.messages', [
            'errorMessages' => $errorMessages ?? [],
            'success'       => $success ?? null,
            'error'         => $error ?? null,
        ])

        <div class="container">
            @yield('content')
        </div>

    </section>

    @include('front.components.footer')

</div>

</body>

</html>
