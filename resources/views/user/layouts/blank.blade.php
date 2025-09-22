<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('user.components.head')

<body>

<div id="app">

    <section class="is-main-section px-4 py-3">

        @include('user.components.messages', [
            'errorMessages' => $errorMessages ?? [],
            'success'       => $success ?? null,
            'error'         => $error ?? null,
        ])

    </section>

</div>

</body>

</html>
