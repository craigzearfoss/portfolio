<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('admin.components.head')

<body>

<div id="app">

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
