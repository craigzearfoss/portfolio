@php
    $href = $href ?? null;
@endphp
<div class="export-buttons-container">
    @include('guest.components.nav-button-export', [ 'href' => $href ])
</div>
