<div class="field">
    <?php /** @TODO: add "for" property to label element */ ?>
    <label class="label">{!! $label ?? $name ?? '' !!}</label>
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
</div>
