@php
    $id    = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    $name  = $name ?? null;
    $value = $value ?? '';

    $list = $list ?? [];

    // if a value was specified that's not in the options list then add it to the options list
    if (!empty($value) && !in_array($value, array_keys($list))) {
        $list[$value] = $value;
    }

    $required = $required ?? false;

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    if (!in_array('form-select', $class)) $class[] = 'form-select';

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

<select
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
    @if (!empty($autofocus))
        autofocus
    @endif
    @if (!empty($readonly))
        disabled
    @endif
    @if (!empty($form))
        form="{!! $form !!}"
    @endif
    @if (!empty($multiple))
        multiple
    @endif
    @if (!empty($onchange))
        onchange="{!! $onchange !!}"
    @endif
    @if (!empty($required))
        required aria-required="true"
    @endif
    @if (!empty($size))
        size="{{ $size }}"
    @endif
>
    @foreach ($list as $listValue=>$listName)
        <option value="{!! $listValue !!}"
                {{ $listValue == $value ? 'selected' : '' }}
        >
            {!! $listName !!}
        </option>
    @endforeach
</select>

@error($name ?? 'name')
    <p class="help is-danger">{!! $message !!}</p>
@enderror
