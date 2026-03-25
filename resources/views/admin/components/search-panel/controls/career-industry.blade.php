@php
    use App\Models\Career\Industry;

    $industry_id = $industry_id ?? request()->query('industry_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'industry_id',
        'label'    => 'industry',
        'value'    => $industry_id,
        'list'     => new Industry()->listOptions(
                          [],
                          'id',
                          'name',
                          0,
                          false,
                          [ 'name', 'asc' ]
                      ),
    ])
</div>
