@php
    use App\Models\System\AdminTeam;

    $owner_id      = $owner_id ?? request()->query('owner_id');
    $isRootAmin    = $isRootAmin ?? false;
    $admin_team_id = $admin_team_id ?? request()->query('admin_team_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'admin_team_id',
        'label'    => 'team',
        'value'    => $admin_team_id,
        'list'     => new AdminTeam()->listOptions(
                          $isRootAmin ? [] : [ 'owner_id' => $owner_id ],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'min-width: 12rem;'
    ])
</div>
