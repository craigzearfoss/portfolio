@php
if ($alt = isset($alt)) {
    $phoneId          = 'inputAlt_phone';
    $phoneName        = 'alt_phone';
    $phoneLabel       = 'alt phone';
    $phoneLabelId     = 'inputAlt_phone_label';
    $phoneLabelName   = 'alt_phone_label';
    $placeholder      = 'alt phone';
    $labelPlaceholder = 'alt phone label';
} else {
    $phoneId          = 'inputPhone';
    $phoneName        = 'phone';
    $phoneLabel       = 'phone';
    $phoneLabelId     = 'inputPhone_label';
    $phoneLabelName   = 'phone_label';
    $placeholder      = 'phone';
    $labelPlaceholder = 'phone label';
}

$class   = !empty($class) ? $class : '';
if (!empty($style)) {
    $style = is_array($style) ? implode('; ', $style) . ';' : $style;
} else {
    $style = '';
}
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="{{ $phoneId }}">{{ $phoneLabel }}</label>
    </div>
    <div class="field-body">
        <div class="content mb-0 mr-2">
            <div class="control has-icons-left">
                <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                       type="tel"
                       id="{!! $phoneId !!}"
                       name="{!! $phoneName !!}"
                       value="{!! $phone !!}"
                       maxlength="20"
                       placeholder="{{ $placeholder }}"
                >
                <span class="icon is-small is-left"><i class="fas fa-phone"></i></span>
            </div>

            @error($phoneName ?? 'name')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

        <div class="content">
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                                   type="text"
                                   id="{{ $phoneLabelId }}"
                                   name="{{ $phoneLabelName }}"
                                   value="{{ $label }}"
                                   maxlength="100"
                                   placeholder="{{ $labelPlaceholder }}"
                            >
                        </div>
                    </div>
                </div>
            </div>

            @error($phoneLabelName ?? 'name')
                <p class="help is-danger">{!! $message !!}</p>
            @enderror

        </div>

    </div>
</div>
