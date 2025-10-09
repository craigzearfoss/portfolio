<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">

@include('admin.components.head')

<body>

@if(isDemo())
    <div class="top-pinned-message has-background-info has-text-white-bis">
        Demo Site
    </div>
@elseif((bool) config('app.readonly'))
    <div class="top-pinned-message has-background-grey-light has-text-grey-dark">
        Site is Read-only
    </div>
@endif

<div id="app">

    @include('admin.components.nav-top')

    @include('admin.components.nav-left')

    @include('admin.components.title-bar', [
        'title'       => $title ?? '',
        'breadcrumbs' => $breadcrumbs ?? []
    ])

    @include('admin.components.subtitle-bar', [
        'title'      => $title ?? '',
        'selectList' => $selectList ?? '',
        'buttons'    => $buttons ?? [],
    ])

    <section class="is-main-section px-4 py-3">

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

</body>

</html>
