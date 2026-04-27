@php
    use App\Models\System\UserTeam;

    $user_id      = $user_id ?? request()->query('user_id');
    $isRootAmin   = $isRootAmin ?? false;
    $user_team_id = $user_team_id ?? request()->query('user_team_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'user_team_id',
        'label'    => 'team',
        'value'    => $user_team_id,
        'list'     => new UserTeam()->listOptions(
                          [],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'min-width: 12rem;'
    ])
</div>
