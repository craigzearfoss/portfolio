<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('front.components.head')

<body>

<div id="app">

    <section class="is-main-section px-4 py-3">

        @include('front.components.messages', [
            'success'=> $success ?? null,
            'error'  => $error ?? null,
            'errors' => $errors ?? [],
        ])

        @yield('content')

    </section>

</div>

</body>

</html>
