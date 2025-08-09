<input
    type="hidden"
    name="{{ $name ?? 'name' }}"
    value="{{ $value ?? '' }}"
    @if (!empty($id))id="{{ $id }}" @endif
>
