@php
    $name    = !empty($name)  ? $name : '#name#';
    $id      = !empty($id) ? $id : ('input' . (!empty($name)  ? ucfirst(trim($name, '#')) : 'Name'));
    $type    = !empty($type) ? $type : 'text';
    $label   = !empty($label) ? $label : (!empty($name) ? $name : '');
    $value   = $value ?? '';
    $class   = !empty($class) ? $class : '';
    if (!empty($style)) {
        $style = is_array($style) ? implode('; ', $style) . ';' : $style;
    } else {
        $style = '';
    }
    $hasIcon = in_array($name, [
        'username',
        'password', 'confirm_password',
        'link', 'postings_url', 'website', 'wikipedia',
        'phone', 'alt_phone', 'home_phone', 'personal_phone', 'work_phone', 'mobile_phone', 'cell_phone',
        'email', 'alt_email', 'work_email', 'personal_email',
        'birthday'
    ]);
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        @if($label !== '-')<label class="label">{{ $label }}</label> @endif
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control {{ !empty($hasIcon) ? 'has-icons-left' : '' }}">
                <input class="input {{ $class }} @error('role') is-invalid @enderror"
                       type="{{ $type }}"
                       id="{{ $id }}"
                       name="{{ $name }}"
                       value="{{ $value }}"
                       style="{{ $style }}"
                       @if (!empty($autocomplete))autocomplete="{{ $autocomplete }}" @endif
                       @if (!empty($autofocus))autofocus="{{ $autofocus }}" @endif
                       @if (!empty($disabled))disabled @endif
                       @if (!empty($form))form="{{ $form }}" @endif
                       @if (!empty($height))height="{{ $height }}" @endif
                       @if (!empty($max))max="{{ $max }}" @endif
                       @if (!empty($maxlength))maxlength="{{ $maxlength }}" @endif
                       @if (!empty($min))min="{{ $min }}" @endif
                       @if (!empty($minlength))minlength="{{ $minlength }}" @endif
                       @if (!empty($placeholder))placeholder="{{ $placeholder }}" @endif
                       @if (!empty($readonly))readonly @endif
                       @if (!empty($required))required @endif
                       @if (!empty($width))width="{{ $width }}" @endif
                >

                @if ($name === 'username')
                    <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                @endif
                @if (in_array($name, ['password', 'confirm_password']))
                    <span class="icon is-small is-left"><i class="fas fa-key"></i></span>
                @endif
                @if (in_array($name, ['link', 'postings_url', 'website', 'wikipedia']))
                    <span class="icon is-small is-left"><i class="fas fa-link"></i></span>
                @endif
                @if (in_array($name, ['phone', 'alt_phone', 'home_phone', 'personal_phone', 'work_phone', 'mobile_phone', 'cell_phone']))
                    <span class="icon is-small is-left"><i class="fas fa-phone"></i></span>
                @endif
                @if (in_array($name, ['email', 'alt_email', 'work_email', 'personal_email']))
                    <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                @endif
                @if (in_array($name, ['birthday']))
                    <span class="icon is-small is-left"><i class="fas fa-birthday-cake"></i></span>
                @endif

            </div>

            @error($name ?? 'name')
                <p class="help is-danger">{{ $message }}</p>
            @enderror

        </div>

    </div>
</div>
