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

@if($resource->hasAttribute('latitude') || $resource->hasAttribute('longitude'))

    <div class="columns {!! $class !!}" {!! $style !!}>
        <div class="column is-2" style="min-width: 6rem;"><strong>coordinates</strong></div>
        <div class="column is-10 pl-0">
            <div>

                <div class="container" style="display: flex; gap: 1em;">

                    <div class="item" style="max-width: 12em; flex: 1; white-space: nowrap;">
                        <span><strong>latitude:</strong></span>
                        <span>{{ $resource->latitude ?? '' }}</span>
                    </div>

                    <div class="item" style="max-width: 12em; flex: 1; white-space: nowrap;">
                        <span><strong>longitude:</strong></span>
                        <span>{{ $resource->longitude ?? '' }}</span>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endif
