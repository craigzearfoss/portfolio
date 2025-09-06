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
        'title' => $title ?? '#title#'
    ])

    <section class="is-main-section px-4 py-3">

        @include('user.components.messages', [
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

<!-- Core Vendors JS -->
<script src="{{ asset('backend/assets/js/vendors.min.js') }}"></script>

<!-- Other Vendors JS -->

<!-- Page js -->
<script src="{{ asset('backend/assets/js/pages/welcome.js') }}"></script>

<!-- Core JS -->
<script src="{{ asset('backend/assets/js/app.min.js') }}"></script>

</body>

</html>
