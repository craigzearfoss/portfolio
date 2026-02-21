@php
    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    $class[] = 'button';
    $class[] = 'is-small';
    $class[] = 'is-dark';

    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];

    $propsArray = [];
    foreach ($props ?? [] as $key=>$value) {
        $propsArray[] = "{$key}={$value}";
    }

    $icon = $icon ?? 'fa-floppy-disk';
@endphp
<div class="field is-horizontal">
    <div class="field-label">
    </div>
    <div class="field-body">
        <div class="field">

            <a
                href="{!! $cancel_url ?? route('user.index') !!}"
                @if (!empty($class))
                    class="{{ implode(' ' , $class) }}"
                @endif
            >
                @if (!empty($icon))
                    <i class="fa-solid fa-close"></i>
                @endif
                Cancel
            </a>

            <button
                type="{{ $type ?? 'submit' }}"
                @if (!empty($name))
                    name="{{ $name }}"
                @endif
                @if (!empty($id))
                    id="{{ $id }}"
                @endif
                @if (!empty($class))
                    class="{{ implode(' ' , $class) }}"
                @endif
                @if (!empty($style))
                    style="{{ implode(' ' , $class) }}"
                @endif
                @if (!empty($onclick))
                    onclick="{!! $onclick !!}"
                @endif
                @if(!empty($disabled) || !empty($readonly))
                    disabled
                @endif
                @if (!empty($propsArray))
                    {!! implode(' ', $propsArray) !!}
                @endif
            >
                @if (!empty($icon))
                    <i class="fa-solid {{ $icon }}"></i>
                @endif
                {!! $label ?? 'Submit' !!}
            </button>

        </div>
    </div>
</div>
