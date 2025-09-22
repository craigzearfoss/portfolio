<!DOCTYPE html>
<html lang="en">

@include('front.components.head')

<body>

<div id="app">

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
