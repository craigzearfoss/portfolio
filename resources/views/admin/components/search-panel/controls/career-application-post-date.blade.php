@php
    $post_date_min = $post_date_min ?? request()->query('post_date-min');
    $post_date_max = $post_date_max ?? request()->query('post_date-max');
@endphp
<div class="card min-max-search-controls">
    <label>posted</label>
    <div>
        <div>
            <span class="min-label">from</span>
        </div>
        <div class="search-form-control">
            @include('admin.components.form-input-with-icon', [
                'type'    => 'date',
                'name'    => 'post_date-min',
                'label'   => '',
                'value'   => $post_date_min,
                'message' => $message ?? '',
                'style'   => [ 'width: 6rem' ],
            ])
        </div>
    </div>
    <div>
        <div>
            <span class="max-label">to</span>
        </div>
        <div class="search-form-control">
            @include('admin.components.form-input', [
                'type'    => 'date',
                'name'    => 'post_date-max',
                'label'   => '',
                'value'   => $post_date_max,
                'message' => $message ?? '',
                'style'   => [ 'width: 6rem' ],
            ])
        </div>
    </div>
</div>
