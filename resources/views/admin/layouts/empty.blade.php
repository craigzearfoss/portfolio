@php
    // get error messages
    $errors = $errors ?? false;
    $errorMessages = [];
    if (empty(!$errors)) {
        $errorMessages = $errors->get('GLOBAL');
        if (empty($errorMessages) && ($errors->any() ?? false)) {
            $errorMessages[] = 'Fix the indicated errors before saving.';
        }
    }

    $title         = $title ?? '';
    $subtitle      = $subtitle ?? false;
    $breadcrumbs   = $breadcrumbs ?? [];
    $navButtons    = $navButtons ?? [];
    $navSelectList = $navSelectList ?? null;
    $prev          = $prev ?? null;
    $next          = $next ?? null;
    $success       = $success ?? session('success') ?? null;
    $error         = $error ?? session('error') ?? null;
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
                'errorMessages' => $errorMessages,
                'success'       => $success,
                'error'         => $error,
            ])

            <div class="container m-0">
                @yield('content')
            </div>

        </section>

        @include('admin.components.footer')

    </div>

    <script src="{{ asset('assets/js/main.js') }}?{{ appTimestamp() }}"></script>

    {!! CookieConsent::scripts() !!}

</body>

</html>
