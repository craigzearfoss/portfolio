@php
    $src = $src ?? '';
    $name = $name ?? 'image';
    $label = $label ?? 'image';
    if (!empty($src)) {
        $label .= <<<EOD
    <a title="preview"
       class="is-small px-1 py-0"
           href="{$src}"
       target="_blank"
    >
        <i class="fa-solid fa-eye"></i>
    </a>
    EOD;
    }
    $class   = !empty($class) ? $class : '';
    if (!empty($style)) {
        $style = is_array($style) ? implode('; ', $style) . ';' : $style;
    } else {
        $style = '';
    }
@endphp

<div class="field is-horizontal">
    <div class="field-label">
        <label class="label">
            {!! $name !!}
            @if (!empty($src))
                <a title="preview"
                   class="is-small px-1 py-0"
                   href="{{ $src ?? '' }}"
                   target="_blank"
                >
                    <i class="fa-solid fa-eye"></i>
                </a>
            @endif
        </label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control ">

                <input class="input"
                       type="text"
                       id="inputImage"
                       name="{{ $name ?? 'image' }}"
                       value="{{ $src ?? '' }}"
                       style="" maxlength="500"
                >

                @if(config('app.upload_enabled'))

                    @include('user.components.form-button-upload', [
                        'name' => !empty($src) ? 'Replace' : 'Upload'
                    ])

                @endif

            </div>
        </div>
    </div>
</div>

@if (($credit !== false) || ($source !== false))

    <div class="field is-horizontal">
        <div class="field-label">
            <label class="label"></label>
        </div>
        <div class="field-body">

            <div class="content mb-0 mr-2">
                <div class="control">

                    @include('user.components.form-input', [
                        'name'      => 'image_credit',
                        'label'     =>  '',
                        'value'     => $credit,
                        'required'  => false,
                        'maxlength' => 500,
                        'placeholder' => 'image credit',
                        'message'   => $message ?? '',
                    ])

                </div>

                @error('image_credit')
                    <p class="help is-danger">{!! $message ?? '' !!}</p>
                @enderror

            </div>

            <div class="content mb-0 ">
                <div class="control">

                    @include('user.components.form-input', [
                        'name'        => 'image_source',
                        'label'       =>  '',
                        'value'       => $source,
                        'required'    => false,
                        'maxlength'   => 500,
                        'placeholder' => 'image source',
                        'message'     => $message ?? '',
                    ])

                </div>

                @error('image_source')
                    <p class="help is-danger">{!! $message ?? '' !!}</p>
                @enderror

            </div>

        </div>
    </div>

@endif
