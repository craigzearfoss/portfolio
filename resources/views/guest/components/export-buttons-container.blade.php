@php
    $href = $href ?? null;
    $filename = $filename ?? 'file.xlsx';
@endphp
<div class="export-buttons-container">
    @include('guest.components.nav-button-export', [
        'href'     => $href,
        'filename' => $filename,
    ])
</div>
