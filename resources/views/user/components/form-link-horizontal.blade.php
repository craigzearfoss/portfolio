@php
    $name               = $name ?? 'link';
    $link               = $link ?? '';
    $link_name          = $link_name ?? '';
    $include_name_field = $include_name_field ?? true;

    $class  = !empty($class)
        ? (is_array($class) ? $class : explode(' ', $class))
        : [];
    if (!in_array('input', $class)) $class[] = 'input';

    $style = !empty($style)
        ? (is_array($style) ? $style : explode(';', $style))
        : [];
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label" for="inputLink" style="min-width: 8em;">{!! $label ?? 'link' !!}</label>
    </div>
    <div class="field-body">

        <div class="content mb-0 mr-1">
            <div class="control has-icons-left">
                <input class="input-link {{ implode(' ', $class) }}@error('role') is-invalid @enderror"
                       type="text"
                       id="{{ 'input' . ucfirst($name) }}"
                       name="{{ $name }}"
                       value="{!! $link !!}"
                       placeholder="url"
                       maxlength="255"
                       @if (!empty($style))
                           {!! implode('; ', $style) !!}
                       @endif
                >
                <span class="icon is-small is-left" style="top: -4px;"><i class="fas fa-link"></i></span>
            </div>

            @error('link')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

        @if ($include_name_field)

            <div class="content mb-0 mr-1">
                <div class="control">
                    <input class="input-link-name {{ implode(' ', $class) }}@error('role') is-invalid @enderror"
                           type="text"
                           id="{{ 'input' . ucfirst($name) . '_name' }}"
                           name="{{ $name . '_name' }}"
                           value="{!! $link_name !!}"
                           placeholder="link name"
                           maxlength="255"
                           @if (!empty($style))
                               {!! implode('; ', $style) !!}
                           @endif
                    >
                </div>

                @error('link_name')
                    <p class="help is-danger">{!! $message ?? '' !!}</p>
                @enderror

            </div>

        @endif

    </div>
</div>
