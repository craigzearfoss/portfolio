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
            width: 30rem;
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

<section class="section main p-2">

    <div class="container" style="max-width: 60rem;">

        <div class="column is-centered has-text-centered">
            <div class="row box title">

                <h1 class="title is-2">
                    A Celebration of Life Picnic
                </h1>
                <h2 class="subtitle is-3 mb-0">
                    Gary "Butch" Zearfoss
                </h2>

                <a class="gary-button" href="/gary/food">
                    View<br>Food List
                </a>

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
                                    <strong>*Use the Greenbriar Rd. entrance</strong>

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

        <div class="column is-centered has-text-centered m-0 p-2" style="max-width: 50rem;" >
            <div class="row box message m-0 p-2">
                This will be a day for the family to share memories and enjoy time together.<br>
                A number of table games and a few other activities will be available.
                <br>(Bring your favorite game if you wish.)
            </div>
        </div>

    </div>

    <div class="container" style="max-width: 60rem;">

        <div class="column is-centered has-text-centered">
            <div class="row box info mb-0 pb-0">

                <div class="max-540">
                    <div class="content has-text-left" style="font-size: 16px; line-height: 1.1;">
                        <ul class="mt-0 ml-4">
                            <li>We will be providing:
                                <div class="content">
                                    <ul>
                                        <li>plates, cups, utensils, napkins</li>
                                        <li>Mission BBQ / slider rolls</li>
                                        <li>chips, Doritos, etc.</li>
                                        <li>cole slaw</li>
                                        <li>mini cupcakes</li>
                                        <li>table games and a few other activities (Bring your favorite game if you wish.)</li>
                                    </ul>
                                </div>
                            </li>
                            <li><strong>Please bring your own drinks.</strong>&nbsp;&nbsp;&nbsp;(Ice will be provided.)</li>
                            <li style="display: none;">The park has 2 small charcoal grills that can be used or you can bring your own grill if you would like.</li>
                            <li style="display: none;">The park has plenty of parking and a children's playground.</li>
                            <li style="display: none;">If you'd like to, feel free to bring food just for yourself.</li>
                            <li>You may wish to bring lawn chairs to sit in the nearby shaded, wooded area.</li>
                            <li>
                                <p class="mb-1">
                                    A small side dish or dessert to share would be welcomed, but not necessary.
                                </p>
                                <p class="mb-2">
                                    You can view the sign up list by clicking on the button below.
                                </p>
                                <a class="gary-button-float button mt-2 font-bold" href="/gary/food">
                                    Click Here to See the Food List
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <table class="table min-540" style="max-width: 60rem;">
                    <tr>
                        <th style="vertical-align: top;">Details</th>
                        <td>
                            <div class="content">
                                <ul class="mt-0 ml-4">
                                    <li>We will be providing:
                                        <div class="content">
                                             <ul>
                                                 <li>plates, cups, utensils, napkins</li>
                                                <li>Mission BBQ / slider rolls</li>
                                                <li>chips, Doritos, etc.</li>
                                                <li>cole slaw</li>
                                                <li>mini cupcakes</li>
                                                <li>table games and a few other activities (Bring your favorites.)</li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><strong>Please bring your own drinks.</strong>&nbsp;&nbsp;&nbsp;(Ice will be provided.)</li>
                                    <li style="display: none;">The park has 2 small charcoal grills that can be used or you can bring your own grill if you would like.</li>
                                    <li style="display: none;">The park has plenty of parking and a children's playground.</li>
                                    <li style="display: none;">If you'd like to, feel free to bring food just for yourself.</li>
                                    <li>You may wish to bring lawn chairs to sit in the nearby shaded, wooded area.</li>
                                    <li>
                                        <p class="mb-1">
                                            A small side dish or dessert to share would be welcomed, but not necessary.
                                        </p>
                                        <p class="mb-2">
                                            You can view the sign up list by clicking on the button below.
                                        </p>
                                        <a class="gary-button-float button mt-2 font-bold" href="/gary/food">
                                            Click Here to See the Food List
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>

    </div>

</section>

</body>
</html>
