@php
    $admin = $admin ?? null;
    $user  = $user ?? null;
    $owner = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('admin.components.head')

<body>

    <div id="app">

        <section class="is-main-section">

            @include('admin.components.messages', [
                'errorMessages' => $errorMessages ?? [],
                'success'       => $success ?? null,
                'error'         => $error ?? null,
            ])

            @yield('content')

        </section>

    </div>

    {!! CookieConsent::scripts() !!}

</body>

</html>
