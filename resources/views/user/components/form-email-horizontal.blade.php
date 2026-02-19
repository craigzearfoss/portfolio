@php
if (empty($alt)) {
    $emailId        = 'inputPhone';
    $emailName      = 'email';
    $emailLabelId   = 'inputPhone_label';
    $emailLabelName = 'email_label';
} else {
    $emailId        = 'inputAlt_email';
    $emailName      = 'alt_email';
    $emailLabelId   = 'inputAlt_email_label';
    $emailLabelName = 'alt_email_label';
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
        <label class="label">{!! empty($alt) ? 'email' : 'alt email' !!}</label>
    </div>
    <div class="field-body">
        <div class="content mb-0 mr-2">
            <div class="control has-icons-left">
                <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                       type="email"
                       id="{!! $emailId !!}"
                       name="{!! $emailName !!}"
                       value="{!! $email !!}"
                       maxlength="255"
                >
                <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
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
                            <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                                   type="text"
                                   id="{!! $emailLabelId !!}"
                                   name="{!! $emailLabelName !!}"
                                   placeholder="label"
                                   value="{!! $label !!}"
                                   maxlength="100"
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
