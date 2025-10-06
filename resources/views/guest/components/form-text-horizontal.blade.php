@php
    $id = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    $raw = isset($raw) ? boolval($raw) : false;
@endphp
<div class="field is-horizontal">
    <div class="field-label is-normal">
        <label class="label">{{ $label ?? $name ?? '#label#' }}</label>
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control">
                <span class="text-field">
                    @if($raw)
                        {!! $value ?? '' !!}
                    @else
                        {{ $value ?? '' }}
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>
