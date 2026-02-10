<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        {{ config('app.name') }} user area
    </title>

    <!-- Bulma is included -->
    <link rel="stylesheet" href="{{ asset('assets/bulma/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

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
    <script src="{{ asset('assets/development-only/main.js') }}"></script>

    @if(config('app.recaptcha_enabled'))
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            function onSubmit(token) {
                document.getElementById("frmMain").submit();
            }
        </script>
    @endif

</head>
@include('user.components.google-tag')
