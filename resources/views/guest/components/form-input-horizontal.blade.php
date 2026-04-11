@php
    $id    = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    $name  = $name ?? null;
    $label = $label ?? $name ?? null;
    $title = $title ?? null;
    $value   = $value ?? '';

    $type    = !empty($type) ? $type : 'text';

    $required = $required ?? false;

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    if (!in_array('input', $class)) $class[] = 'input';

    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];

    $labelClass = [ 'label' ];
    if ($required && !in_array('label-required', $labelClass)) $labelClass[] = 'label-required';

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

        @if(isset($label) && ($label === '') )
        @else

            <label
                @if($id)
                   for="{{ $id }}"
                @endif
                class="{{ implode(' ', $labelClass) }}"
                @if($title)
                    title="{{ $title }}"
                @endif
            >
                {!! $label ?? $name !!}
            </label>

        @endif

    </div>
    <div class="field-body">
        <div class="field">
            <div class="control {{ !empty($hasIcon) ? 'has-icons-left' : '' }}">

                @include('guest.components.input', [
                    'type'         => $type,
                    'id'           => $id,
                    'name'         => $name,
                    'label'        => $label,
                    'title'        => $title,
                    'class'        => $class,
                    'style'        => $style,
                    'autocomplete' => $autocomplete ?? false,
                    'autofocus'    => $autofocus ?? false,
                    'form'         => $form ?? null,
                    'height'       => $height ?? null,
                    'max'          => $max ?? null,
                    'maxlength'    => $maxlength ?? null,
                    'multiple'     => $multiple ?? null,
                    'pattern'      => $pattern ?? null,
                    'placeholder'  => $placeholder ?? null,
                    'readonly'     => $readonly ?? null,
                    'required'     => $required ?? null,
                    'step'         => $step ?? false,
                    'width'         => $width ?? false,
                ])

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

        </div>

    </div>
</div>
