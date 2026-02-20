<div class="field is-horizontal">
    <div class="field-label">
        <?php /** @TODO: add "for" property to label element */ ?>
        <label class="label">
            {!! $label ?? $name ?? '' !!}
            @if (!empty($src))
                <a title="preview"
                   class="is-small px-1 py-0"
                   href="{{ $src }}"
                   target="_blank"
                >
                    <i class="fa-solid fa-eye"></i>
                </a>
            @endif
        </label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control {{ !empty($hasIcon) ? 'has-icons-left' : '' }}">
                <div class="file has-name">
                    <label class="file-label" for="inputFile">
                        <input class="file-input" type="file" id="inputFile" name="{!! $name !!}">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choose a file…
                            </span>
                        </span>
                        <span class="file-name">
                            {!! $src ?? '' !!}
                        </span>
                    </label>

                    @if(!empty($text))
                        <span class="ml-2 pt-1"><i>{!! $text !!}</i></span>
                    @endif

                </div>
            </div>

            @error('image')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>
    </div>
</div>
