@php
    $href = $href ?? null;
    $filename = $filename ?? 'file.xlsx';

    // add timestamp url parameter
    if (!empty($href) && ($timestamp ?? true)) {
        if (!str_contains($href, '?')) {
            $href = $href . '?timestamp';
        } else {
            $href = $href . '&timestamp';
        }
    }
@endphp
<div class="export-buttons-container">
    @include('guest.components.nav-button-export', [
        'href'     => $href,
        'filename' => $filename,
    ])
</div>
