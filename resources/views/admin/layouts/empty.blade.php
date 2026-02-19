@php
    $admin            = $admin ?? null;
    $user             = $user ?? null;
    $owner            = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">

@include('admin.components.head')

<body>

    <div id="app">

        <section class="is-main-section">

            @include('admin.components.messages', [
                'errorMessages' => $errorMessages ?? [],
                'success'       => $success ?? null,
                'error'         => $error ?? null,
            ])

            <div class="container">
                @yield('content')
            </div>

        </section>

        @include('admin.components.footer')

    </div>

    {!! CookieConsent::scripts() !!}

</body>

</html>
