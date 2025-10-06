<div class="field">
    <label class="label">{{ $label ?? $name ?? '#label#' }}</label>
    <div class="control {{ !empty($hasIcon) ? 'has-icons-left' : '' }}">
        <div class="file has-name">
            <label class="file-label">
                <input class="file-input" type="file" name="resume">
                <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Choose a file…
                    </span>
                </span>
                <span class="file-name">
                    {{ $value ?? '' }}
                </span>
            </label>
        </div>
    </div>
</div>
