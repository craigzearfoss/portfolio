<a
    href="{{ $cancel_url ?? route('front.dashboard') }}"
    class="btn btn-sm btn-solid"
><i class="fa-solid fa-close"></i> Cancel</a>

@if ($demo)
    <button
        type="button"
        class="btn btn-sm btn-solid"
        {{ !empty($disabled) || !empty($readonly) ? 'disabled' : '' }}
        onclick="alert('You cannot update data because the site is in demo mode.')"
    ><i class="fa-solid fa-floppy-disk"></i> {{ $label ?? 'Submit' }}</button>
@else
    <button
        type="{{ $type ?? 'submit' }}"
        @if (!empty($name))name="{{ $name }}" @endif
        @if (!empty($id))name="{{ $id }}" @endif
        class="btn btn-sm btn-solid" {{ $class ?? '' }}
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
        @if (!empty($onclick))onclick="{{ $onclick }}" @endif
        {{ !empty($disabled) || !empty($readonly) ? 'disabled' : '' }}
    ><i class="fa-solid fa-floppy-disk"></i> {{ $label ?? 'Submit' }}</button>
@endif
