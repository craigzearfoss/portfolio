<?php
$googleTag = config('app.google_tag');
?>
@if(!empty($googleTag) && (config('app.env') === 'production'))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$googleTag}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{$googleTag}}');
    </script>
@endif
