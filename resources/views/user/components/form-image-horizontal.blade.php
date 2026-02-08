@php
$class   = !empty($class) ? $class : '';
if (!empty($style)) {
    $style = is_array($style) ? implode('; ', $style) . ';' : $style;
} else {
    $style = '';
}
@endphp
<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">{!! $label ?? 'image' !!}</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control {{ !empty($hasIcon) ? 'has-icons-left' : '' }}">
                <div class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choose a file…
                            </span>
                        </span>
                        <span class="file-name">
                            {!! $image ?? '' !!}
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

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label"></label>
    </div>
    <div class="field-body">

        <div class="content mb-0 mr-2">
            <div class="control">
                <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputImage_credit"
                       name="image_credit"
                       value="{!! $credit !!}"
                       placeholder="image credit"
                       maxlength="255"
                >
            </div>

            @error('image_credit')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

        <div class="content mb-0 ">
            <div class="control">
                <input class="input {!! $class !!} @error('role') is-invalid @enderror"
                       type="text"
                       id="inputImage_source"
                       name="image_source"
                       value="{{ $source }}"
                       placeholder="image source"
                       maxlength="255"
                >
            </div>

            @error('image_source')
                <p class="help is-danger">{!! $message ?? '' !!}</p>
            @enderror

        </div>

    </div>
</div>
