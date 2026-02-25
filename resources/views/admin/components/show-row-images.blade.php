@php
    $download     = $download ?? false;
    $external     = $external ?? false;

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
    if (!empty($display)) $styleArray[] = 'display: '. $display . ';';
    if (!empty($whiteSpace)) $styleArray[] = 'white-space: '. $whiteSpace . ';';
    if (!empty($styleArray)) {
        $styles = array_merge($styles, $styleArray);
    }
@endphp
<div @if(!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if(!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
    <div class="column is-2 label">
        @if(!empty($name))
            <strong>{!! $name !!}</strong>:
        @endif
    </div>
    <div class="column is-10 value">

        <div class="floating-div-container">

            @if(!empty($resource))

                @foreach([
                    'certificate_url',
                    'image',
                    'thumbnail',
                    'logo',
                    'logo_small',
                ] as $imageName)

                    @if($resource->hasAttribute($imageName))

                        <div class="floating-div p-2 mb-2 mr-2" style="border: 1px solid #ccc;">

                            <strong>{{ str_replace('_', ' ', $imageName) }}</strong>
                            <br>

                            @if(!empty($resource->{$imageName}))

                                @php

                                    switch ($imageName) {
                                        case 'certificate_url':
                                            $src           = $resource->certificate_url;
                                            $downloadType  = 'certificate';
                                            $suffix        = null;
                                            $width         = '300px';
                                            break;
                                        case 'image':
                                            $src           = $resource->image;
                                            $downloadType  = 'image';
                                            $suffix        = null;
                                            $width         = '300px';
                                            break;
                                        case 'logo':
                                            $src           = $resource->logo;
                                            $downloadType  = 'logo';
                                            $suffix        = '-logo';
                                            $width         = '100px';
                                            break;
                                        case 'logo_small':
                                            $src           = $resource->logo_small;
                                            $downloadType  = 'small logo';
                                            $suffix        = '-logo-small';
                                            $width         = '100px';
                                            break;
                                        case 'thumbnail':
                                            $src           = $resource->thumbnail;
                                            $downloadType  = 'thumbnail';
                                            $suffix        = '-thumbnail';
                                            $width         = '100px';
                                            break;
                                        default:
                                            $downloadType  = 'image';
                                            $suffix        = null;
                                            $width         = null;
                                            break;
                                    }

                                    $filename = generateDownloadFilename($resource, $suffix);

                                @endphp

                                @include('admin.components.image', [
                                    'name'     => 'image',
                                    'src'      => $src,
                                    'filename' => $filename,
                                    'alt'      => $downloadType,
                                    'width'    => $width,
                                    'download' => $download,
                                    'external' => $external,
                                ])

                                @if($imageName === 'image')
                                    <div class=flex">
                                        <strong>image credit:</strong>
                                        <span>{{ $resource->image_credit }}</span>
                                    </div>
                                    <div class=flex">
                                        <strong>image source:</strong>
                                        <span>{{ $resource->image_source ?? '' }}</span>
                                    </div>
                                @endif

                            @endif

                        </div>

                    @endif

                @endforeach

            @endif

        </div>

    </div>
</div>
