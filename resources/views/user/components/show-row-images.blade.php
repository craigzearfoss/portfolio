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
    <div class="column is-2" style="min-width: 6rem;"><strong>{{ $name ?? 'images' }}</strong>:</div>
    <div class="column is-10 pl-0">

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
                                            $imageName = 'certificate url';
                                            $src   = $resource->certificate_url;
                                            $width = '300px';
                                            break;
                                        case 'image':
                                            $src   = $resource->image;
                                            $width = '300px';
                                            break;
                                        case 'logo':
                                            $src   = $resource->logo;
                                            $width = '100px';
                                            break;
                                        case 'logo_small':
                                            $imageName = 'logo small';
                                            $src   = $resource->logo_small;
                                            $width = '100px';
                                            break;
                                        case 'thumbnail':
                                            $src   = $resource->thumbnail;
                                            $width = '100px';
                                            break;
                                        default:
                                            $width = null;
                                            break;
                                    }
                                @endphp

                                @include('user.components.image', [
                                    'name'     => 'image',
                                    'src'      => $src,
                                    'alt'      => htmlspecialchars($imageName ?? ''),
                                    'width'    => $width,
                                    'download' => $download ?? false,
                                    'external' => $external ?? false,
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
