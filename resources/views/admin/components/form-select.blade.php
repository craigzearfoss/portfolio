<div class="mb-3">
    <label for="input{{ !empty($name) ? ucfirst($name) : 'Name' }}" class="form-label mb-1">{{ $label ?? $name ?? '#label#' }}</label>
    <select
        id="input{{ !empty($name) ? ucfirst($name) : 'Name' }}"
        name="{{ $name ?? 'name' }}"
        class="form-select {{ $class ?? '' }}"
        @if (!empty($style))style="{{ is_array($style) ? (implode('; ', $style) . ';') : $style }}" @endif
        @if (!empty($autofocus))autofocus @endif
        @if (!empty($readonly))disabled @endif
        @if (!empty($form))form="{{ $form }}" @endif
        @if (!empty($multiple))multiple @endif
        @if (!empty($required))required @endif
        @if (!empty($size))size="{{ $size }}" @endif
    >
        @foreach ($list as $listValue=>$listName)
            <option value="{{ $listValue }}" @if ($listValue == $value)selected @endif >
                {{ $listName }}
            </option>
        @endforeach
    </select>
    @error($name ?? 'name')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>
