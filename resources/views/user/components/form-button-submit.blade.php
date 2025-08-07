<button type="submit"
        class="btn btn-sm btn-solid {{ $class ?? '' }}"
        @if (!empty($style))style="{{ is_array($style) ? implode('; ', $style) . ';' : $style }}" @endif
>
    {{ $label ?? 'Submit' }}
</button>
