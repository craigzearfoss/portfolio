@php
    $id    = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    $name  = $name ?? null;
    $value = $value ?? '';

    $type  = !empty($type) ? $type : 'text';

    $required = $required ?? false;

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    if (!in_array('input', $class)) $class[] = 'input';

    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];

    $hasIcon = in_array($name, [
        'username',
        'password', 'confirm_password',
        'link', 'postings_url', 'website', 'wikipedia',
        'phone', 'alt_phone', 'home_phone', 'personal_phone', 'work_phone', 'mobile_phone', 'cell_phone',
        'email', 'alt_email', 'work_email', 'personal_email',
        'birthday'
    ]);
@endphp

@error('role')
    @php
        $class[] = 'is-invalid';
    @endphp
@enderror

<input
    type="{{ $type }}"
    @if($id)
        id="{{ $id }}"
    @endif
    @if($name)
        name="{{ $name }}"
    @endif
    @if(!empty($class))
        class="{{ implode(' ', $class) }}"
    @endif
    @if (!empty($style))
        style="{{ implode('; ', $style) }}"
    @endif
    value="{!! $value !!}"
    @if (!empty($autocomplete))
        autocomplete="{{ $autocomplete }}"
    @endif
    @if (!empty($autofocus))
        autofocus
    @endif
    @if (!empty($form))
        form="{{ $form }}"
    @endif
    @if (!empty($height))
        height="{{ $height }}"
    @endif
    @if (!empty($max))
        max="{{ $max }}"
    @endif
    @if (!empty($maxlength))
        maxlength="{{ $maxlength }}"
    @endif
    @if (!empty($min))
        min="{{ $min }}"
    @endif
    @if (!empty($multiple))
        multiple="{{ $multiple }}"
    @endif
    @if (!empty($pattern))
        pattern="{{ $pattern }}"
    @endif
    @if (!empty($placeholder))
        placeholder="{!! $placeholder !!}"
    @endif
    @if (!empty($readonly))
        disabled
    @endif
    @if (!empty($required))
        required aria-required="true"
    @endif
    @if (!empty($step))
        step="{{ $step }}"
    @endif
    @if (!empty($width))
        width="{{ $width }}"
    @endif
>

    @error($name ?? 'name')
        <p class="help is-danger">{!! $message !!}</p>
    @enderror
