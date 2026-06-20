@php
    $classes = !empty($class)
        ? (is_array($class) ? $class : explode(' ', $class))
        : [];
    $classes[] ='property-list';
    $classes[] ='columns';

    $styles = !empty($style)
        ? (is_array($style) ? $style : explode(';', $style))
        : [];

    // get styles for defined properties
    $styleArray = [];
    if (!empty($width)) $styleArray[] = 'width: '. $width . ';';
    if (!empty($minWidth)) $styleArray[] = 'min-width: '. $minWidth . ';';
    if (!empty($whiteSpace)) $styleArray[] = 'white-space: '. $whiteSpace . ';';

    if (!empty($display)) {
        $styleArray[] = 'display: '. $display;
    } elseif (!empty($hide)) {
        $styleArray[] = 'display: none';
    }

    if (!empty($styleArray)) {
        $styles = array_merge($styles, $styleArray);
    }

    $columns = [
        'is_public'   => 'public',
        'is_readonly' => 'read-only',
        'is_root'     => 'root',
        'is_disabled' => 'disabled',
        'is_demo'     => 'demo',
    ];
@endphp
<div @if (!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if (!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
    <div class="column is-2 label">
        <strong>contact info</strong>:
    </div>
    <div class="column left-align is-10 value pr-4 mb-3 mr-4">

        <div class="floating-div-container">

            @if ($resource->hasAttribute('phone') || $resource->hasAttribute('alt_phone'))

                <div class="show-container card floating-div" style="padding: 4px !important; margin-bottom: 8px !important;">
                    <table class="table admin-table {{ $adminTableClasses ?? '' }}" style="margin-bottom: 0 !important;">
                        <tr class="is-size-7">
                            <th></th>
                            <th>number</th>
                            <th>label</th>
                        </tr>

                        @foreach (['phone', 'alt_phone'] as $col)
                            @php $colLabel = $col . '_label'; @endphp
                            @if ($resource->hasAttribute($col))

                                <tr>
                                    <th style="white-space: nowrap;">
                                        {{ str_replace('_', ' ', $col) }}
                                    </th>
                                    <td style="white-space: nowrap; min-width: 8rem;">
                                        {{ $resource->{$col} }}
                                    </td>
                                    <td style="white-space: nowrap; min-width: 8rem;">
                                        {{ $resource->{$colLabel} ?? '' }}
                                    </td>
                                </tr>

                            @endif
                        @endforeach

                    </table>
                </div>

            @endif

            @if ($resource->hasAttribute('email') || $resource->hasAttribute('alt_email'))

                <div class="show-container card floating-div" style="padding: 4px !important; margin-bottom: 8px !important;">
                    <table class="table admin-table {{ $adminTableClasses ?? '' }}" style="margin-bottom: 0 !important;">
                        <tr class="is-size-7">
                            <th></th>
                            <th>address</th>
                            <th>label</th>
                        </tr>

                        @foreach (['email', 'alt_email'] as $col)
                            @php $colLabel = $col . '_label'; @endphp
                            @if ($resource->hasAttribute($col))

                                <tr>
                                    <th style="white-space: nowrap;">
                                        {{ str_replace('_', ' ', $col) }}
                                    </th>
                                    <td style="white-space: nowrap; min-width: 8rem;">
                                        {{ $resource->{$col} }}
                                    </td>
                                    <td style="white-space: nowrap; min-width: 8rem;">
                                        {{ $resource->{$colLabel} ?? '' }}
                                    </td>
                                </tr>

                            @endif
                        @endforeach

                    </table>
                </div>

            @endif

        </div>

    </div>
</div>
