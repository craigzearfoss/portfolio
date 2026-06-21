@php
    use App\Models\Career\RecruiterIndustry;

    $recruiter_industry_id = $recruiter_industry_id ?? request()->query('recruiter_industry_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'recruiter_industry_id',
        'label'    => 'industry',
        'value'    => $recruiter_industry_id,
        'list'     => new RecruiterIndustry()->listOptions(
                          [],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'width: 12rem;'
    ])
</div>
