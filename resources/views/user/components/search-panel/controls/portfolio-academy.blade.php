@php
    use App\Models\Portfolio\Academy;

    $academy_id = $academy_id ?? request()->query('academy_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
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
        'style'    => 'width: 16rem;'
    ])
</div>
