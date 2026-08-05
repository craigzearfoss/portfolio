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
        iframe.spreadsheet-iframe {
            width: 100%;
            height: 80rem;
            float: left;
            margin: 6px;
            overflow: scroll;
            border: 1px solid black;
        }
    </style>
</head>
<body>

<div class="row has-text-centered mt-4">
</div>

<section class="section">

    <div class="container" style="max-width: 60rem;">

        <div class="column is-centered has-text-centered">
            <div class="row box title">

                <h1 class="title is-2">
                    A Celebration of Life Picnic
                </h1>
                <h2 class="subtitle is-3">
                    Gary "Butch" Zearfoss
                </h2>

            </div>
        </div>

        <div class="columns is-centered">

            <div class="column is-half">
                <div class="box info">
                    <table class="table" style="max-width: 40rem;">
                        <tbody>
                        <tr>
                            <th style="vertical-align: top;">Date & Time</th>
                            <td>September 5, 2026 - Noon till (??)</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="column is-half">
                <div class="box info">
                    <table class="table" style="max-width: 40rem;">
                        <tbody>
                        <tr>
                            <th style="vertical-align: top;">Location: </th>
                            <td>
                                <strong>Cousler Park</strong>, Pavillions T & P, <br>
                                1060 Church Rd.<br>
                                York, PA 17404<br>
                                <a target="_blank" href="https://www.mantwp.com/cousler-park/">https://www.mantwp.com/cousler-park/</a>
                                <p class="mt-2" style="display: none;">
                                    Near the playground.<br>
                                    Use the entrance across from the church on Greenbriar Road.
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="column is-centered has-text-centered" style="max-width: 50rem;" >
            <div class="row box message">
                This will be a day for the family to share memories and enjoy time together.<br>
                A number of table games and a few other activities will be available.
                <br>(Bring your favorite games.)
            </div>
        </div>

    </div>

    <div class="container" style="max-width: 60rem;">

        <div class="column is-centered has-text-centered">
            <div class="row box info">

                <table class="table" style="max-width: 40rem;">
                    <tr>
                        <th style="vertical-align: top;">Details</th>
                        <td>
                            <div class="content">
                                <ul class="mt-0 ml-4">
                                    <li>We will be providing:
                                        <div class="content">
                                            <ul>
                                                <li>paper plates, cups, utensils</li>
                                                <li>Mission BBQ sliders</li>
                                                <li>hot dogs for the grill</li>
                                                <li>chips, Doritos, etc.</li>
                                                <li>broccoli salad, cole slaw, & macaroni salad</li>
                                                <li>mini cupcakes</li>
                                                <li>table games and a few other activities (Bring your favorites.)</li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><strong>Please bring your own drinks.</strong></li>
                                    <li style="display: none;">The park has 2 small charcoal grills that can be used or you can bring your own grill if you would like.</li>
                                    <li style="display: none;">The park has plenty of parking and a children's playground.</li>
                                    <li style="display: none;">If you'd like to, feel free to bring food just for yourself.</li>
                                    <li>
                                        We are not organizing food, but if you'd like to bring a side dish or dessert to share please add it to the spreadsheet below to help other people decide what they want to bring.
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>

                            <iframe class="spreadsheet-iframe"
                                    src="https://docs.google.com/spreadsheets/d/187jIxxYcjhX4jKvSfpRDo9ltPCRtry9Dl8bYohYhOCo/edit?gid=0#gid=0"
                            >
                            </iframe>

                        </td>
                    </tr>
                </table>

            </div>
        </div>

    </div>

</section>

</body>
</html>
