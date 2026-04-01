@php
    use App\Models\Career\Industry;

    $industry_id = $industry_id ?? request()->query('industry_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
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
        'style'    => 'width: 19rem;'
    ])
</div>
