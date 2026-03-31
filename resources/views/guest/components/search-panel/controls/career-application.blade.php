@php
    use App\Models\Career\Application;

    $owner_id        = $owner_id ?? request()->query('owner_id');
    $isRootAmin      = $isRootAmin ?? false;
    $application_id  = $application_id ?? request()->query('application_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'application_id',
        'label'    => 'application',
        'value'    => $application_id,
        'list'     => new Application()->listOptions(
                          $isRootAmin ? [] : [ 'owner_id' => $owner_id ],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'desc' ]
                      ),
    ])
</div>
