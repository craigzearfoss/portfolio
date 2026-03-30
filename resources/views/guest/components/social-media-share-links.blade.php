@php
    $page = $page ?? null;
    $title = $title ?? config('app.name');

    $shareLinks = '';

    if (!empty($page)) {

        $shareLinks = Share::page($page, $title);
        foreach (config('app.share_sites') as $shareSite) {
            switch ($shareSite) {
                case 'facebook':
                    $shareLinks->facebook();
                    break;
                case 'linkedin':
                    $shareLinks->linkedin();
                    break;
                case 'reddit':
                    $shareLinks->reddit();
                    break;
                case 'telegram':
                    $shareLinks->telegram();
                    break;
                case 'twitter':
                    $shareLinks->twitter();
                    break;
                case 'whatsapp':
                    $shareLinks->whatsapp();
                    break;
            }
        }
    }
@endphp
<div class="is-flex is-justify-content-flex-end pr-4 mt-2">
    @if(!empty($shareLinks))
        {!! $shareLinks !!}
    @endif
</div>
