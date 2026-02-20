@php
$class   = !empty($class) ? $class : '';
if (!empty($style)) {
    $style = is_array($style) ? implode('; ', $style) . ';' : $style;
} else {
    $style = '';
}
@endphp
<div class="field is-horizontal">
    <div class="field-label is-normal">
    </div>
    <div class="field-body">
        <div class="field" style="flex-grow: 0;">

            <div class="checkbox-container card form-container p-4">

                @include('user.components.form-checkbox', [
                    'name'            => 'public',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $public ?? 0,
                    'message'         => $message ?? '',
                ])

                @include('user.components.form-checkbox', [
                    'name'            => 'readonly',
                    'label'           => 'read-only',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $readonly ?? 0,
                    'message'         => $message ?? '',
                ])

                @if(isRootAdmin())
                    @include('user.components.form-checkbox', [
                        'name'            => 'root',
                        'value'           => 1,
                        'unchecked_value' => 0,
                        'checked'         => $root ?? 0,
                        'disabled'        => $root ?? 0,
                        'message'         => $message ?? '',
                    ])
                @endif

                @include('user.components.form-checkbox', [
                    'name'            => 'disabled',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $disabled ?? 0,
                    'message'         => $message ?? '',
                ])

                @include('user.components.form-checkbox', [
                    'name'            => 'demo',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $demo ?? 0,
                    'message'         => $message ?? '',
                ])

                <div style="display: inline-block; width: 10em;">
                    <label class="label" for="inputSequence" style="display: inline-block !important;">sequence</label>
                    <span class="control ">
                        <input class="input"
                               style="margin-top: -4px;"
                               type="number"
                               id="inputSequence"
                               name="sequence"
                               min="0"
                               value="{{ $sequence ?? 0 }}"
                        >
                    </span>

                    @error('sequence')
                        <p class="help is-danger">{{ $message ?? '' }}</p>
                    @enderror

                </div>

            </div>

        </div>
    </div>
</div>
