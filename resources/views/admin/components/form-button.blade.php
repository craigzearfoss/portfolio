<button
    type="{{ $type ?? 'submit' }}"
    @if (!empty($name))name="{!! $name !!}" @endif
    @if (!empty($id))id="{!! $id !!}" @endif
    class="button {!! $class ?? '' !!}"
    @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
    @if (!empty($onclick))onclick="{!! $onclick !!}" @endif
    {{ !empty($disabled) || !empty($readonly) ? 'disabled' : '' }}
>
    @if (!empty($icon))<i class="fa-solid {{ $icon }}"></i> @endif
    {!! $label ?? 'Submit' !!}
</button>
