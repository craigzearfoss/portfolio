<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('admin.components.head')

<body>

<div id="app">

    @include('admin.components.nav-top')

    @include('admin.components.nav-left')

    @include('admin.components.title-bar', [
        'title'       => $title ?? '#title#',
        'breadcrumbs' => $breadcrumbs ?? []
    ])

    @include('admin.components.subtitle-bar', [
        'title' => $title ?? '#title#'
    ])

    <section class="is-main-section px-4 py-3">

        @include('admin.components.messages', [
            'success'=> $success ?? null,
            'error'  => $error ?? null,
            'errors' => $errors ?? [],
        ])

        <div class="container">
            @yield('content')
        </div>

    </section>

    @include('admin.components.footer')

</div>

</body>

</html>
