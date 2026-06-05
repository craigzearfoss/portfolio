@php
    // @TODO: The logic of this page is quite circuitous and should probably cleaned up at some point.

    use Illuminate\Support\Str;

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
        <strong>images</strong>
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

                        @if (!empty($resource->{$imageName}))

                            @php

                                switch ($imageName) {
                                    case 'certificate_url':
                                        $src           = $resource->certificate_url;
                                        $downloadType  = 'certificate';
                                        $href          = imageUrl($resource->certificate_url);
                                        $suffix        = null;
                                        $width         = '300px';
                                        $download = $external = !empty($resource->image) && !Str::startsWith($resource->image, 'http');
                                        break;
                                    case 'image':
                                        $src           = $resource->image;
                                        $downloadType  = 'image';
                                        $href          = imageUrl($resource->image);
                                        $suffix        = null;
                                        $width         = '300px';
                                        break;
                                    case 'logo':
                                        $src           = $resource->logo;
                                        $downloadType  = 'logo';
                                        $href          = imageUrl($resource->logo);
                                        $suffix        = '-logo';
                                        $width         = '100px';
                                        break;
                                    case 'logo_small':
                                        $src           = $resource->logo_small;
                                        $downloadType  = 'small logo';
                                        $href          = imageUrl($resource->logo_small);
                                        $suffix        = '-logo-small';
                                        $width         = '100px';
                                        break;
                                    case 'thumbnail':
                                        $src           = $resource->thumbnail;
                                        $downloadType  = 'thumbnail';
                                        $href          = imageUrl($resource->thumbnail);
                                        $suffix        = '-thumbnail';
                                        $width         = '100px';
                                        break;
                                    default:
                                        $downloadType  = 'image';
                                        $href          = '';
                                        $suffix        = null;
                                        $width         = null;
                                        break;
                                }

                                $filename = generateDownloadFilename($resource, $suffix);
                                $imageTitle = str_replace(get_class($resource) . ': ', '', getResourcePageTitle($resource, false))
                            @endphp

                        @endif

                        <div class="floating-div p-2 mb-2 mr-2" style="border: 1px solid #ccc;">

                            <div style="display: block;">
                                <div style="display: inline-block; width: 100%;">
                                    <strong>{{ str_replace('_', ' ', $imageName) }}</strong>

                                    @if (!empty($resource->{$imageName}))
                                        <div style="display: inline-block; float: right;">
                                            @include('admin.components.download-links', [
                                                'href'     => $href,
                                                'download' => $download,
                                                'external' => $external,
                                            ])
                                        </div>
                                    @endif

                                </div>
                                <div style="display: inline-block; float: right;">

                                    @if ($upload)

                                        @if ($resource->{$imageName})
                                            @include('admin.components.button-remove-image', [
                                                'label'         => empty($resource->{$imageName}) ? 'Upload' : 'Replace',
                                                'resource_type' => 'Career\Application',
                                                'resource'      => $resource,
                                                'column'        => $imageName,
                                                'target_data'   => 'resource-' . $imageName,
                                            ])
                                        @endif

                                        @if (config('app.upload_enabled'))
                                            @include('admin.components.button-upload-image', [
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

                                    @if (!empty($filename))
                                        @include('admin.components.image', [
                                            'name'     => 'image',
                                            'title'    => $imageTitle,
                                            'src'      => $src,
                                            'filename' => $filename,
                                            'alt'      => htmlspecialchars($downloadType),
                                            'width'    => $width,
                                            'download' => false, // download link is created above the image
                                            'external' => false, // external link is created above the image
                                        ])
                                    @endif

                                    @if ($imageName === 'image')

                                        @if ($editPage)

                                            <div>
                                                <div style="display: inline-block; width: 65px;">
                                                    <label for="inputImage_credit" class="label">credit:</label>
                                                </div>
                                                <div style="display: inline-block;">
                                                    <input type="text" id="inputImage_credit" name="image_credit"
                                                           class="input" value="{{ $resource->image_credit ?? '' }}"
                                                           style="width: 100%;">
                                                </div>
                                            </div>
                                            <div>
                                                <div style="display: inline-block; width: 65px;">
                                                    <label for="inputImage_credit" class="label">source:</label>
                                                </div>
                                                <div style="display: inline-block;">
                                                    <input type="text" id="inputImage_credit" name="image_credit"
                                                           class="input" value="{{ $resource->image_source ?? '' }}"
                                                           style="width: 100%;">
                                                </div>
                                            </div>

                                        @else

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

                                @else

                                    @if ($editPage)
                                        <i>
                                            No {{ $imageName }} has been uploaded.
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
