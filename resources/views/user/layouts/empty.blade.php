@php
    $currentRouteName = $currentRouteName ?? null;
    $admin            = $admin ?? null;
    $user             = $user ?? null;
    $owner            = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">

@include('user.components.head')

<body>

<div id="app">

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
