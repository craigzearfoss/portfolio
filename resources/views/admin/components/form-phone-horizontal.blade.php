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

$phoneClass = !empty($class)
    ? (!is_array($class) ? explode(' ', $class) : $class)
    : [];
if (!in_array('input', $phoneClass)) $phoneClass[] = 'input';
$phoneLabelClass = $phoneClass;
if (!in_array('input-phone', $phoneClass)) $phoneClass[] = 'input-phone';
if (!in_array('input-phone-label', $phoneLabelClass)) $phoneLabelClass[] = 'input-phone-label';

$style = !empty($style)
    ? (!is_array($style) ? explode(';', $style) : $style)
    : [];
@endphp
<div class="field is-horizontal mb-0">
    <div class="field-label">
        <label class="label" for="{{ $phoneId }}">{{ $phoneLabel }}</label>
    </div>
    <div class="field-body">
        <div class="content mb-0 mr-2">
            <div class="control has-icons-left">
                <input class="{{ implode(' ', $phoneClass) }}@error('role') is-invalid @enderror"
                       type="tel"
                       id="{!! $phoneId !!}"
                       name="{!! $phoneName !!}"
                       value="{!! $phone !!}"
                       maxlength="20"
                       placeholder="{{ $placeholder }}"
                       @if (!empty($style))
                           style="{!! implode('; ', $style) !!}"
                       @endif
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
                            <input class="{{ implode(' ', $phoneLabelClass) }}@error('role') is-invalid @enderror"
                                   type="text"
                                   id="{{ $phoneLabelId }}"
                                   name="{{ $phoneLabelName }}"
                                   value="{{ $label }}"
                                   maxlength="100"
                                   placeholder="{{ $labelPlaceholder }}"
                                   @if (!empty($style))
                                       style="{!! implode('; ', $style) !!}"
                                   @endif
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
