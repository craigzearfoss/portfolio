@php
    use App\Models\Career\Company;

    $owner_id   = $owner->id ?? -1;
    $company_id = $company_id ?? request()->query('company_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'company_id',
        'label'    => 'company',
        'value'    => $company_id,
        'list'     => new Company()->listOptions(
                          [ 'owner_id' => $owner_id ],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'min-width: 12rem;'
    ])
</div>
