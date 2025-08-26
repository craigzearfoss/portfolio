<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('images/site/favicon.ico') }}">
    <title>{{ !empty($title) ? $title . ' - ' : ''  }}{{ config('app.name') }}</title>

    <?php /*
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style.css') }}">

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    */ ?>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-3.4.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome-free-7.0.0-web/css/all.min.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style.css') }}">

    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
</head>
