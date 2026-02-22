@php
    $title         = $title ?? '';
    $subtitle      = $subtitle ?? false;
    $breadcrumbs   = $breadcrumbs ?? [];
    $navButtons    = $navButtons ?? [];
    $navSelectList = $navSelectList ?? null;
    $prev          = $prev ?? null;
    $next          = $next ?? null;
    $errorMessages = $errorMessages = [];
    $success       = $success ?? null;
    $error         = $error ?? null;
    $menuService   = $menuService ?? null;
    $admin         = $admin ?? null;
    $user          = $user ?? null;
    $owner         = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">

@include('guest.components.head')

<body>

    <div id="app">

        <section class="is-main-section">

            @include('guest.components.messages', [
                'errorMessages' => $errorMessages ?? [],
                'success'       => $success ?? null,
                'error'         => $error ?? null,
            ])

            <div class="container">
                @yield('content')
            </div>

        </section>

        @include('guest.components.footer')

    </div>

    {!! CookieConsent::scripts() !!}

</body>

</html>
