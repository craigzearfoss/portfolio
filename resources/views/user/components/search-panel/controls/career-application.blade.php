@php
    use App\Models\Career\Application;

    $owner_id        = $owner->id ?? -1;
    $application_id  = $application_id ?? request()->query('application_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'application_id',
        'label'    => 'application',
        'value'    => $application_id,
        'list'     => new Application()->listOptions(
                          [ 'owner_id' => $owner_id ],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'desc' ]
                      ),
        'style'    => 'min-width: 12rem;'
    ])
</div>
