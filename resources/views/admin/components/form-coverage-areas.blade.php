<div class="checkbox-container card form-container p-4">

    @include('admin.components.form-checkbox', [
        'name'            => 'local',
        'value'           => 1,
        'unchecked_value' => 0,
        'checked'         => old('local') ?? $resource->local ?? false,
        'message'         => $message ?? '',
    ])

    @include('admin.components.form-checkbox', [
        'name'            => 'regional',
        'value'           => 1,
        'unchecked_value' => 0,
        'checked'         => old('regional') ?? $resource->regional ?? false,
        'message'         => $message ?? '',
    ])

    @include('admin.components.form-checkbox', [
        'name'            => 'national',
        'value'           => 1,
        'unchecked_value' => 0,
        'checked'         => old('national') ?? $resource->national ?? false,
        'message'         => $message ?? '',
    ])

    @include('admin.components.form-checkbox', [
        'name'            => 'international',
        'value'           => 1,
        'unchecked_value' => 0,
        'checked'         => old('international') ?? $resource->international ?? false,
        'message'         => $message ?? '',
    ])

</div>
