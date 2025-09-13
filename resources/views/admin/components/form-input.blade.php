@php
    $name    = !empty($name)  ? $name : '#name#';
    $id      = !empty($id) ? $id : ('input' . (!empty($name)  ? ucfirst(trim($name, '#')) : 'Name'));
    $type    = !empty($type) ? $type : 'text';
    $label   = !empty($label) ? $label : (!empty($name) ? $name : '#label#');
    $value   = !empty($value) ? $value : '';
    $class   = !empty($class) ? $class : '';
    if (!empty($style)) {
        $style = is_array($style) ? implode('; ', $style) . ';' : $style;
    } else {
        $style = '';
    }
    $hasIcon = ($type === 'email') || in_array($name, ['username', 'password', 'confirm_password', 'link', 'website', 'wikipedia']);
@endphp
<div class="field">
    @if($label !== '-')<label class="label">{{ $label }}</label> @endif
    <div class="control {{ $hasIcon ? 'has-icons-left' : '' }}">
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

        @if ($type === 'email')
            <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
        @endif
        @if ($name === 'username')
            <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
        @endif
        @if (in_array($name, ['password', 'confirm_password']))
            <span class="icon is-small is-left"><i class="fas fa-key"></i></span>
        @endif
        @if (in_array($name, ['link', 'website', 'wikipedia']))
            <span class="icon is-small is-left"><i class="fas fa-link"></i></span>
        @endif

    </div>

    @error($name ?? 'name')
        <p class="help is-danger">{{ $message }}</p>
    @enderror

</div>
