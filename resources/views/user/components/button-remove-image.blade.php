@php
    if (empty($resource_type)) {
        abort(500, 'No $resource_type parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'button-upload-image.blade.php.');
    }

    if (empty($resource)) {
        abort(500, 'No $resource parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'button-upload-image.blade.php.');
    }

    if (empty($column)) {
        abort(500, 'No $column parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'button-upload-image.blade.php.');
    }

    $name   = $name ?? 'Remove';

    $classes = !empty($class)
        ? is_array($class) ? $class : explode(' ', $class)
        : [];
    $classes = array_merge([ 'remove-image-button', 'button', 'is-small', 'px-1', 'py-0' ], $classes);

@endphp
<button @if (!empty($title))title="{{ $title }}" @endif
    @if (!empty($classes))class="{{ implode(' ', $classes) }}" @endif
    @if (!empty($style))style="{!! is_array($style) ? implode('; ', $style) . ';' : $style !!}" @endif
    @if (!empty($disabled))style="cursor: default; opacity: 0.5;" @endif
    @if (!empty($href))href="{{ $href }}" @endif
    @if (!empty($onclick))
        onclick="{!! $onclick !!}"
    @endif
    data-resource_type="{{ $resource_type }}"
    data-resource_id="{{ $resource->id }}"
    data-column="{{ $column }}"
    data-target="{{ url()->current() }}"
>
    <i class="fa {!! !empty($icon) ? $icon : 'fa-trash' !!}"></i>{{ $name }}
</button>
