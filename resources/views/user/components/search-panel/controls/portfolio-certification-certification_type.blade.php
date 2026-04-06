@php
    use App\Models\Portfolio\CertificationType;

    $certification_type_id = $certification_type_id ?? request()->query('certification_type_id');
@endphp
<div class="control" style="max-width: 30rem;">
    @include('user.components.form-select', [
        'name'     => 'certification_type_id',
        'label'    => 'type',
        'label'    => 'type',
        'value'    => $certification_type_id,
        'list'     => new CertificationType()->listOptions([], 'id', 'name', true),
        'style'    => 'width: 13rem;'
    ])
</div>
