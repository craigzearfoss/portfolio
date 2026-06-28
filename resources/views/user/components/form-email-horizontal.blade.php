@php
if ($alt = isset($alt)) {
    $emailId          = 'inputAlt_email';
    $emailName        = 'alt_email';
    $emailLabel       = 'alt email';
    $emailLabelId     = 'inputAlt_email_label';
    $emailLabelName   = 'alt_email_label';
    $placeholder      = 'alt email';
    $labelPlaceholder = 'alt email label';
} else {
    $emailId          = 'inputEmail';
    $emailName        = 'email';
    $emailLabel       = 'email';
    $emailLabelId     = 'inputEmail_label';
    $emailLabelName   = 'email_label';
    $placeholder      = 'email';
    $labelPlaceholder = 'email label';
}

$emailClass = !empty($class)
    ? (!is_array($class) ? explode(' ', $class) : $class)
    : [];
if (!in_array('input', $emailClass)) $emailClass[] = 'input';
$emailLabelClass = $emailClass;
if (!in_array('input-email', $emailClass)) $emailClass[] = 'input-email';
if (!in_array('input-email-label', $emailLabelClass)) $emailLabelClass[] = 'input-email-label';

$style = !empty($style)
    ? (!is_array($style) ? explode(';', $style) : $style)
    : [];
@endphp
<div class="field is-horizontal mb-0">
    <div class="field-label">
        <label class="label" for="{{ $emailId }}">{{ $emailLabel }}</label>
    </div>
    <div class="field-body">
        <div class="content mb-0 mr-2">
            <div class="control has-icons-left">
                <input class="{{ implode(' ', $emailClass) }}@error('role') is-invalid @enderror"
                       type="email"
                       id="{!! $emailId !!}"
                       name="{!! $emailName !!}"
                       value="{!! $email !!}"
                       maxlength="255"
                       placeholder="{{ $placeholder }}"
                       @if (!empty($style))
                           style="{!! implode('; ', $style) !!}"
                       @endif
                >
                <span class="icon is-small is-left" style="top: -4px;"><i class="fas fa-envelope"></i></span>
            </div>

            @error($emailName ?? 'name')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

        <div class="content">
            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="{{ implode(' ', $emailLabelClass) }}@error('role') is-invalid @enderror"
                                   type="text"
                                   id="{{ $emailLabelId }}"
                                   name="{{ $emailLabelName }}"
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

            @error($emailLabelName ?? 'name')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

    </div>
</div>
