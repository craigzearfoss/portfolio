@php
    $appUrl = (config('app.url'));
    $domain = trim($appUrl);
    $domain = str_contains($appUrl, '/')
        ? trim(strrchr($appUrl, '/', false), '/')
        : $appUrl;
@endphp

@if (!in_array($domain, ['portfolio.test', 'zearfoss.com', 'staging.zearfoss.com']))
    @php
        abort(404);
    @endphp
@endif
<html lang="en" dir="ltr">
<head>
    <title>Gary "Butch" Zearfoss Celebration of Life</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css" type="text/css">

    <style>
        body {
            font-size: 1.1rem !important;
            background-color: #d5c9c2;
        }
        section.section.main {
            padding-bottom: 0;
        }
        div.box.title {
            background-color: #d8e3e1;
        }
        div.box.message {
            background-color: #a6b8b1;
            /*border: #a6b8b1 inset 4px;*/
            font-size: 1.2rem;
        }
        div.box.info {
            background-color: #ffffff;
        }
        div.container.google-sheet-container {
            background-color: #d5c9c2;
            max-width: 60rem;
        }
        iframe.spreadsheet-iframe {
            min-width: 40rem;
            max-width: 100%;
            height: 80rem;
            float: left;
            margin: 6px;
            border: 1px solid black;
        }
        a.gary-button {
            position: absolute;
            top: 0;
            right: 0;
            margin: 24px;
            font-size: 1.2rem;
            padding: 0.5rem;
            font-weight: 800;
            background-color: #f4e1bb;
        }
        a.gary-button-float {
            margin: 24px;
            font-size: 1.2rem;
            padding: 0.5rem;
            font-weight: 800;
            background-color: #f4e1bb;
        }
        @media screen and (max-width: 540px) {
            table.min-540 {
                display: none;
            }
            div.max-540 {
                display: block;
            }
        }
        @media screen and (min-width: 540px) {
            table.min-540 {
                display: block;
            }
            div.max-540 {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="row has-text-centered mt-4">
</div>

<section class="section main p-2">

    <div class="container" style="max-width: 60rem;">

        <div class="column is-centered has-text-centered">

            <div class="row box title">

                <h1 class="title is-2">
                    A Celebration of Life Picnic
                </h1>
                <h2 class="subtitle is-3 mb-1">
                    Gary "Butch" Zearfoss
                </h2>

                <h2 class="subtitle is-3 mb-0">
                    Food List
                </h2>

                <a class="gary-button" href="/gary" style="">
                    Back to<br>Main Page
                </a>

            </div>
        </div>

        <div class="has-text-centered" style="max-width: 40rem;">
            <p class=" pb-2">
                You can bring small side dish or dessert to share if you would like, but it is not necessary.
                This a list of what people intend to bring.
            </p>
            <p>
                <i>
                    * If you are on a computer please add your item to this list, but you will not be able edit the list from a phone or iPad.
                </i>
            </p>
        </div>

        <div class="column is-centered has-text-centered" style="height: 100%;">
            <div class="row">

                <iframe
                    class="spreadsheet-iframe"
                    src="https://docs.google.com/spreadsheets/d/187jIxxYcjhX4jKvSfpRDo9ltPCRtry9Dl8bYohYhOCo/edit?usp=sharing
?widget=true&amp;headers=false&rm=minimal&amp;&single=true&amp;"
                ></iframe>

            </div>
        </div>

    </div>

</section>

</body>
</html>
