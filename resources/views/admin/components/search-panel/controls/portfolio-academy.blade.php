@php
    use App\Models\Portfolio\Academy;

@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'academy_id',
        'label'    => 'academy',
        'value'    => $academy_id,
        'list'     => new Academy()->listOptions(
                          [],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'min-width: 6rem;'
    ])
</div>
