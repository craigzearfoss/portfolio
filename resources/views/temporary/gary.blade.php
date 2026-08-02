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
</head>
<body style="font-size: 2rem !important;">
<h3 class="subtitle mt-3 mb-2 ml-2">
    Gary "Butch" Zearfoss Celebration of Life
</h3>
<table class="table">
    <tr>
        <th style="vertical-align: top;">Date</th>
        <td>September 5, 2026</td>
    </tr>
    <tr>
        <th style="vertical-align: top;">Time</th>
        <td>
            noon (We will start serving food at 12:15, but it will be available all afternoon.)
        </td>
    </tr>
    <tr>
        <th style="vertical-align: top;">Location: </th>
        <td>
            Cousler Park<br>
            Pavillions T & P<br>
            1060 Church Rd.<br>
            York, PA 17404
        </td>
    </tr>
    <tr>
        <th style="vertical-align: top;">Website</th>
        <td><a target="_blank" href="https://www.mantwp.com/cousler-park/">https://www.mantwp.com/cousler-park/</a></td>
    </tr>
    <tr>
        <th style="vertical-align: top;">Details</th>
        <td>
            <div class="content">
                <ul class="mt-0 ml-4">
                    <li>We will be providing:
                        <div class="content">
                            <ul>
                                <li>Mission BBQ</li>
                                <li>hot dogs, rolls, and fixings</li>
                                <li>paper plates, cups, utensils</li>
                                <li>board, card, and lawn games (Bring your favorites.)</li>
                            </ul>
                        </div>
                    </li>
                    <li>Bring your own beverages.</li>
                    <li>The park has 2 small charcoal grills that can be used or you can bring your own grill if you would like.</li>
                    <li>The park has plenty of parking and a children's playground.</li>
                    <li>If you'd like to, feel free to bring food just for yourself.</li>
                    <li>
                        We are not organizing food, but if you'd like to bring food to share please add it to the spreadsheet below to help other people decide what they want to bring.
                    </li>
                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>

            <iframe style="width: 40rem; height: 80rem; float: left; margin-left: 6rem;"
                    src="https://docs.google.com/spreadsheets/d/187jIxxYcjhX4jKvSfpRDo9ltPCRtry9Dl8bYohYhOCo/edit?gid=0#gid=0"
            >
            </iframe>

        </td>
    </tr>
</table>

</body>
</html>
