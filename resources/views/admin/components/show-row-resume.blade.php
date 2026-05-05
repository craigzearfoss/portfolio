@php
    use Illuminate\Support\Str;

    if (empty($resume)) {
        abort(500, 'No $resume parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'show-row-resume.blade.php.');
    }

    if (empty($filetype)) {
        abort(500, 'No $filetype parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'show-row-resume.blade.php. Valid $filetypes are `pdf` and `doc`.');
    } elseif (!in_array($filetype, [ 'doc', 'pdf' ])) {
        abort(500, 'Invalid $filetype `' . $filetype . '` specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'show-row-resume.blade.php. Valid $filetypes are `pdf` and `doc`.');
    }

    $filename = str_replace('Resume: ', '', getResourcePageTitle($resume, false));

    switch ($filetype) {
        case 'pdf':
            $href = imageUrl($resume->pdf_filepath);
            $label = 'PDF file:';
            break;
        case 'doc':
            $href = imageUrl($resume->doc_filepath);
            $label = 'Word file:';
            break;
        default:
            $href = imageUrl($resume->doc_filepath);
            $label = 'file:';
            break;
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
    $classes[] ='property-list';
    $classes[] ='columns';

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
    <div class="column is-2 label" style="min-width: 6rem;">
        @if (!empty($label))
            <strong>{!! $label !!}</strong>
        @endif
    </div>
    <div class="column is-10 value">

        @if (!empty($href))

            <div style="flex: 1; padding: 5px;">
                <iframe src="{{ $href }}"
                        style="width:100%; min-height:300px; border: 1px solid #ccc;">
                </iframe>
            </div>

        @endif

    </div>
</div>
