<a
    href="{{ $cancel_url ?? route('guest.homepage') }}"
    class="button"
><i class="fa-solid fa-close"></i> Cancel</a>

@if ($demo)
    <button
        type="button"
        class="button"
        {{ !empty($disabled) || !empty($readonly) ? 'disabled' : '' }}
        onclick="alert('You cannot update data because the site is in demo mode.')"
    ><i class="fa-solid fa-floppy-disk"></i> {{ $label ?? 'Submit' }}</button>
@else
    <button
        type="{{ $type ?? 'submit' }}"
        @if (!empty($name))name="{{ $name }}" @endif
        @if (!empty($id))name="{{ $id }}" @endif
        class="button {{ $class ?? '' }}"
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
        @if (!empty($onclick))onclick="{{ $onclick }}" @endif
        {{ !empty($disabled) || !empty($readonly) ? 'disabled' : '' }}
    ><i class="fa-solid fa-floppy-disk"></i> {{ $label ?? 'Submit' }}</button>
@endif
