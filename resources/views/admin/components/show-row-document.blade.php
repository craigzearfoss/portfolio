@php
    use Illuminate\Support\Str;

    if (empty($resource)) {
        abort(500, 'No $resource parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'button-upload-document.blade.php.');
    }

    $column        = $column ?? 'filepath';
    $label         = $label ?? 'file';
    $href          = imageUrl($resource->{$column});
    $fileExtension = substr(strrchr($href, '.'), 1);
    $filename      = $filename ?? 'file';

    $accept   = !empty($accept)
        ? is_array($accept) ? $accept : array_map(function($val) { return trim($val); }, explode(',', $accept))
        : [ 'doc', 'docx', 'pdf' ];
    if (empty($accept)) {
        $accept = [ 'doc', 'docx', 'pdf' ];
    }
    $editPage = $editPage ?? false;

    if (!$resource->hasAttribute($column)) {
        abort(500, 'No column `' . $column . '` not found for `' . get_class($resource) . '` in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'button-upload-document.blade.php.');
    }


    // get download link
    if (!empty($filepath)) {
        $downloadLink = view('admin.components.link', [
            'name'       => '<i class="fa-solid fa-download"></i>',
            'href'       => $href,
            'target'     => '_blank',
            'class'      => 'resume-download',
            'attributes' => [ 'data-filename' => Str::slug($filename) ]
        ]);

        $label = $label . ' ' . $downloadLink;
    }

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
    if (!empty($width)) $styleArray[] = 'width: '. $width;
    if (!empty($minWidth)) $styleArray[] = 'min-width: '. $minWidth;
    if (!empty($whiteSpace)) $styleArray[] = 'white-space: '. $whiteSpace;

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
    <div class="{{ $editPage ? 'field-label' : 'column is-2 label' }}" style="min-width: 6rem;">

        <strong>{!! $label ?? 'file' !!}</strong>

        @if (!empty($resource->{$column}))
            @include('admin.components.download-links', [
                'name'     => 'image',
                'href'     => $href,
                'filename' => Str::slug($filename),
                'download' => true,
                'external' => !empty($href) && !in_array($fileExtension, [ 'doc', 'docx' ]),
            ])
        @endif

        @if (!$editPage && config('app.upload_enabled'))
            @include('admin.components.button-upload-document', [
                'modalTitle'  => (empty($resource->{$column}) ? 'Upload ' : 'Replace ') . $label,
                'label'       => empty($resource->{$column}) ? 'Upload' : 'Replace',
                'resource'    => $resource,
                'column'      => $column,
                'target_data' => 'resource-' . str_replace('_', '-', $column),
                'accept'      => implode(',', $accept),
            ])
        @endif
</div>
<div class="{{ $editPage ? 'field-body' : 'column is-10 value' }}">

@if (!empty($href))

    <div style="flex: 1; padding: 5px;">

        @if (in_array($fileExtension, [ 'doc', 'docx' ]))

            <iframe src="{{ route('view-document', [ 'file' => $href ]) }}" style="width:100%; min-height:30rem; border: 1px solid #ccc;">
            </iframe>

        @else

            <iframe src="{{ $href }}" style="width:100%; min-height:300px; border: 1px solid #ccc;">
            </iframe>

        @endif

    </div>

@else

    <i>
        No document has been uploaded.
        <br>
        Add via the show page.
    </i>

@endif

</div>
</div>
