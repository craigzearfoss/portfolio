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
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('guest.components.head')

<body>

    <div id="app">

        <section class="is-main-section">

            @include('guest.components.messages', [
                'errorMessages' => $errorMessages,
                'success'       => $success,
                'error'         => $error,
            ])

            <div class="container m-0">
                @yield('content')
            </div>

        </section>

    </div>

    <script src="{{ asset('assets/js/main.js') }}?{{ appTimestamp() }}"></script>

    {!! CookieConsent::scripts() !!}

</body>

</html>
