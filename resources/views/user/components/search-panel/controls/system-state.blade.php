@php
    use App\Models\System\State;

    $state_id = $state_id ?? request()->query('state_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'state_id',
        'label'    => 'state',
        'value'    => $state_id,
        'list'     => new State()->listOptions(
                          [],
                          'id',
                          'name',
                          0,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'min-width: 6rem;'
    ])
</div>
