<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/site/favicon.ico') }}">
    <title>
        {{ !empty($pageTitle)
                ? ($pageTitle . ' - ')
                : (!empty($title) ? $title . ' - ' : '')
        }}
        {{ config('app.name') }}
    </title>

    <!-- Bulma is included -->
    <link rel="stylesheet" href="{{ asset('assets/bulma/css/main.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome-free-7.0.0-web/css/all.min.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
<?php /*
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-3.4.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome-free-7.0.0-web/css/all.min.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style.css') }}">
*/ ?>

    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

</head>
