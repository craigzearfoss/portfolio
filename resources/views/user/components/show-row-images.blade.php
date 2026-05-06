@php
    $upload   = $upload ?? false;
    $download = $download ?? false;
    $external = $external ?? false;
    $editPage = $editPage ?? false;

    $classes = !empty($class)
        ? (is_array($class) ? $class : explode(' ', $class))
        : [];
    if ($editPage) {
        $classes[] ='field';
        $classes[] ='is-horizontal';
    } else {
        $classes[] ='property-list';
        $classes[] ='columns';
    }

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
@endphp
<div @if (!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if (!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
    <div class="{{ $editPage ? 'field-label' : 'column is-2 label' }}">
        <strong>images</strong>:
    </div>
    <div class="{{ $editPage ? 'field-body' : 'column is-10 value' }}">

        <div class="floating-div-container">

            @if (!empty($resource))

                @foreach ([
                    'certificate_url',
                    'image',
                    'thumbnail',
                    'logo',
                    'logo_small',
                ] as $imageName)

                    @if ($resource->hasAttribute($imageName))

                        <div class="floating-div p-2 mb-2 mr-2" style="border: 1px solid #ccc;">

                            <div style="display: block;">
                                <div style="display: inline-block;">
                                    <strong>{{ str_replace('_', ' ', $imageName) }}</strong>
                                </div>
                                <div style="display: inline-block; float: right;">

                                    @if ($upload)

                                        @if (config('app.upload_enabled'))
                                            @include('user.components.button-upload-image', [
                                                'label'       => empty($resource->{$imageName}) ? 'Upload' : 'Replace',
                                                'resource'    => $resource,
                                                'column'      => $imageName,
                                                'target_data' => 'resource-' . $imageName,
                                            ])
                                        @else
                                            <strong>UPLOAD_IMAGE setting not enabled in .env file.</strong>
                                        @endif

                                    @endif

                                </div>
                            </div>

                            <div>

                                @if (!empty($resource->{$imageName}))

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
                                        $imageTitle = str_replace(get_class($resource) . ': ', '', getResourcePageTitle($resource, false))
                                    @endphp

                                    @if (!empty($filename))
                                        @include('user.components.image', [
                                            'name'     => 'image',
                                            'title'    => $imageTitle,
                                            'src'      => $src,
                                            'filename' => $filename,
                                            'alt'      => $downloadType,
                                            'width'    => $width,
                                            'download' => $download,
                                            'external' => $external,
                                        ])
                                    @endif

                                    @if ($imageName === 'image')
                                        <div class=flex">
                                            <strong>image credit:</strong>
                                            <span>{{ $resource->image_credit }}</span>
                                        </div>
                                        <div class=flex">
                                            <strong>image source:</strong>
                                            <span>{{ $resource->image_source ?? '' }}</span>
                                        </div>
                                    @endif

                                @else

                                    @if ($editPage)
                                        <i>
                                            No image has been uploaded.
                                            <br>
                                            Add via the show page.
                                        </i>
                                    @endif

                                @endif

                            </div>

                        </div>

                    @endif

                @endforeach

            @endif

        </div>

    </div>
</div>
