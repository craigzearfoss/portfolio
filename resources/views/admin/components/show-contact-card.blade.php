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
<div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll">

    <div class="mr-4" style="display: inline-block; min-width: 20rem; vertical-align: top;">

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                'street'          => $resource->street ?? '',
                'street2'         => $resource->street2 ?? '',
                'city'            => $resource->city ?? '',
                'state'           => $resource->state->code ?? '',
                'zip'             => $resource->zip ?? '',
                'country'         => $resource->country->iso_alpha3 ?? '',
                'streetSeparator' => '<br>',
            ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $resource
        ])

    </div>
    <div class="mr-4" style="display: inline-block; min-width: 15rem; vertical-align: top;">

        @if ($resource->hasAttribute('phone'))
            @include('admin.components.show-row', [
                'name'  => $resource->phone_label ?? 'phone',
                'value' => $resource->phone ?? ''
            ])
        @endif

        @if ($resource->hasAttribute('alt_phone'))
            @include('admin.components.show-row', [
                'name'  => $resource->alt_phone_label ?? 'alt phone',
                'value' => $resource->alt_phone ?? ''
            ])
        @endif

        @if ($resource->hasAttribute('email'))
            @include('admin.components.show-row', [
                'name'  => $resource->email_label ?? 'email',
                'value' => $resource->email ?? ''
            ])
        @endif

        @if ($resource->hasAttribute('alt_email'))
            @include('admin.components.show-row', [
                'name'  => $resource->alt_email_label ?? 'alt email',
                'value' => $resource->alt_email ?? ''
            ])
            @endif

    </div>

</div>
