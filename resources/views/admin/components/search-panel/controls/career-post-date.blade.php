@php
    $posted_from = $posted_from ?? request()->query('posted_from');
    $posted_to   = $posted_to ?? request()->query('posted_to');
@endphp
<div class="search-form-control">
    @include('admin.components.input-basic', [
        'type'     => 'date',
        'name'     => 'posted_from',
        'label'    => 'posted from',
        'value'    => $posted_from,
        'nohidden' => true,
    ])
</div>
<div class="search-form-control">
    @include('admin.components.input-basic', [
        'type'     => 'date',
        'name'     => 'post_to',
        'label'    => 'posted to',
        'value'    => $posted_to,
        'nohidden' => true,
    ])
</div>
