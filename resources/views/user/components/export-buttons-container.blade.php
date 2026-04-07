@php
    $href = $href ?? null;
@endphp
<div class="export-buttons-container">
    @include('user.components.nav-button-export', [ 'href' => $href ])
</div>
