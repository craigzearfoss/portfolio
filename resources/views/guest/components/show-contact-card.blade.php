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

        @include('guest.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                'street'          => htmlspecialchars($resource->street ?? ''),
                'street2'         => htmlspecialchars($resource->street2 ?? ''),
                'city'            => htmlspecialchars($resource->city ?? ''),
                'state'           => $resource->state->code ?? '',
                'zip'             => htmlspecialchars($resource->zip ?? ''),
                'country'         => $resource->country->iso_alpha3 ?? '',
                'streetSeparator' => '<br>',
            ])
        ])

        @include('guest.components.show-row-coordinates', [
            'resource' => $resource
        ])

    </div>
    <div class="mr-4" style="display: inline-block; min-width: 15rem; vertical-align: top;">

        @if ($resource->hasAttribute('phone'))
            @include('guest.components.show-row', [
                'name'  => htmlspecialchars($resource->phone_label ?? 'phone'),
                'value' => htmlspecialchars($resource->phone)
            ])
        @endif

        @if ($resource->hasAttribute('alt_phone'))
            @include('guest.components.show-row', [
                'name'  => htmlspecialchars($resource->alt_phone_label ?? 'alt phone'),
                'value' => htmlspecialchars($resource->alt_phone)
            ])
        @endif

        @if ($resource->hasAttribute('email'))
            @include('guest.components.show-row', [
                'name'  => htmlspecialchars($resource->email_label ?? 'email'),
                'value' => htmlspecialchars($resource->email)
            ])
        @endif

        @if ($resource->hasAttribute('alt_email'))
            @include('guest.components.show-row', [
                'name'  => htmlspecialchars($resource->alt_email_label ?? 'alt email'),
                'value' => htmlspecialchars($resource->alt_email)
            ])
            @endif

    </div>

</div>
