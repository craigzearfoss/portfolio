@php
    use App\Models\System\Country;

    $country_id = $country_id ?? request()->query('country_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'  => 'country_id',
        'label' => 'country',
        'value' => $country_id,
        'list'  => new Country()->listOptions(
                       [],
                       'id',
                       'name',
                       true,
                       false,
                       [ 'name', 'asc' ]
                   ),
        'style' => 'min-width: 6rem;'
    ])
</div>
