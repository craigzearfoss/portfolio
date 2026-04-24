@php
    $title         = $title ?? '';
    $subtitle      = $subtitle ?? false;
    $breadcrumbs   = $breadcrumbs ?? [];
    $navButtons    = $navButtons ?? [];
    $navSelectList = $navSelectList ?? null;
    $prev          = $prev ?? null;
    $next          = $next ?? null;
    $errorMessages = $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving. ' . implode(' ', $errors->all())]
        : [];
    $errorMessages = $errorMessages = [];
    $success       = $success ?? session('success') ?? null;
    $error         = $error ?? session('error') ?? null;
    $menuService   = $menuService ?? null;
    $admin         = $admin ?? null;
    $user          = $user ?? null;
    $owner         = $owner ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">

@include('user.components.head')

<body>

    <div id="app">

        <section class="is-main-section">

            @include('user.components.messages', [
                'errorMessages' => $errorMessages,
                'success'       => $success,
                'error'         => $error,
            ])

            <div class="container">
                @yield('content')
            </div>

        </section>

        @include('user.components.footer')

    </div>

    <script src="{{ asset('assets/js/main.js') }}?{{ appTimestamp() }}"></script>

    {!! CookieConsent::scripts() !!}

</body>

</html>
