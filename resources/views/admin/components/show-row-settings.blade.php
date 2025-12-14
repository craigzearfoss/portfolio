@php
$styles = [];
if (!empty($width)) $styles[] = 'width: '. $width . ';';
if (!empty($minWidth)) $styles[] = 'min-width: '. $minWidth . ';';
if (!empty($display)) $styles[] = 'display: '. $display . ';';
if (!empty($whiteSpace)) $styles[] = 'white-space: '. $whiteSpace . ';';

$style = !empty($styles) ? ('style="' . implode('; ', $styles) . ';"') : '';
$class = $class ?? '';
$resource = $resource ?? null;
@endphp
<div class="columns {!! $class !!}" {!! $style !!}>
    <div class="column is-2" style="min-width: 6rem;"><strong></strong></div>
    <div class="column is-10 pl-0">
        <div>

            <div class="container" style="display: flex; gap: 1em;">

                @if($resource->hasAttribute('sequence'))

                    <div class="item" style="padding: 0.3em; border: 1px solid #ccc; flex: 1; white-space: nowrap;">
                        <span><strong>sequence:</strong></span>
                        <span>{{ empty($resource->sequence) ? $resource->sequence : '0' }}</span>
                    </div>

                @endif

                @foreach(['public', 'readonly', 'root', 'disabled', 'demo'] as $setting)

                    @if($resource->hasAttribute($setting))

                        <div class="item" style="padding: 0.3em; border: 1px solid #ccc; flex: 1; white-space: nowrap;">
                            <span>
                                @include('admin.components.checkbox', [ 'checked' => !empty($resource->{$setting}) ])
                            </span>
                            <span><strong>{{ $setting == 'readonly' ? 'read-only' : $setting }}</strong></span>
                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    </div>
</div>
