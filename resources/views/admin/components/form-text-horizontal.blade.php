@php
    $id         = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    $raw        = isset($raw) && boolval($raw);
    $hide       = $hide ?? false;
    $text_title = $text_title ?? '';
@endphp
<div class="field is-horizontal"
     @if ($hide)
         style="display: none;"
     @endif
>
    <div class="field-label is-normal">
        <label class="label">{!! $label ?? $name ?? '' !!}</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control has-text-left">
                <span class="text-field"
                      @if (!empty($text_title))
                          title="{{ $text_title }}"
                      @endif
                >
                    @if ($raw)
                        {!! $value ?? '' !!}
                    @else
                        {!! $value ?? '' !!}
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>
