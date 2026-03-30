<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:url"                content="{{ $share_url ?? url()->current() }}" />
    <meta property="og:title"              content="{{ $title ?? config('app.name') }}" />
    <meta property="og:description"        content="{{ config('app.name') }}" />
    <meta property="og:image"              content="http://static01.nyt.com/images/2015/02/19/arts/international/19iht-btnumbers19A/19iht-btnumbers19A-facebookJumbo-v2.jpg" />
    <meta property="fb:app_id"             content="{{ config('app.facebook_app_id') }}" />

    <link rel="shortcut icon" href="{{ asset('images/site/favicon.ico') }}">
    <title>
        @php
            $pageTitle = !empty($pageTitle)
                ? $pageTitle
                : $title ?? ''
        @endphp
        @if(!empty($pageTitle) && ($pageTitle !== config('app.name')))
            {{$pageTitle}} -
        @endif
        {{ config('app.name') }}
    </title>

    <!-- Bulma is included -->
    <link rel="stylesheet" href="{{ asset('assets/bulma/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?{{ appTimestamp() }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome-free-7.0.0-web/css/all.min.css') }}">

    {!! CookieConsent::styles() !!}

<?php /*
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
*/ ?>
<?php /*
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-3.4.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome-free-7.0.0-web/css/all.min.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style.css') }}">
*/ ?>

    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/development-only/main.js') }}?{{ appTimestamp() }}"></script>

    @if(config('app.recaptcha_enabled'))
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            function onSubmit(token) {
                document.getElementById("frmMain").submit();
            }
        </script>
    @endif

</head>
@include('guest.components.google-tag')
