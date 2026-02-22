@php
    $title         = $title ?? '';
    $subtitle      = $subtitle ?? false;
    $breadcrumbs   = $breadcrumbs ?? [];
    $buttons       = $buttons ?? [];
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
