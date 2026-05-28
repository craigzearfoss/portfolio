@php
    $free ?? true;
    $premium ?? false;
    $staffing ?? false;
    $freelance ?? false;

    $class   = !empty($class) ? $class : '';
    if (!empty($style)) {
        $style = is_array($style) ? implode('; ', $style) . ';' : $style;
    } else {
        $style = '';
    }
@endphp
<div class="field is-horizontal">
    <div class="field-label is-normal">
        <strong>details</strong>
    </div>
    <div class="field-body">
        <div class="field" style="flex-grow: 0;">

            <div class="checkbox-container card form-container p-4">

                @include('admin.components.form-checkbox', [
                    'name'            => 'free',
                    'label'           => 'free',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $free ?? 0,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-checkbox', [
                    'name'            => 'premium',
                    'label'           => 'premium',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $premium ?? 0,
                    'message'         => $message ?? '',
                ])

                @if (isRootAdmin())
                    @include('admin.components.form-checkbox', [
                        'name'            => 'staffing',
                        'label'           => 'staffing',
                        'value'           => 1,
                        'unchecked_value' => 0,
                        'checked'         => $staffing ?? 0,
                        'message'         => $message ?? '',
                    ])
                @endif

                @include('admin.components.form-checkbox', [
                    'name'            => 'freelance',
                    'label'           => 'freelance',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $freelance ?? 0,
                ])

            </div>

        </div>
    </div>
</div>
