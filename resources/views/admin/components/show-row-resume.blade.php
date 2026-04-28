@php
    $filetype = $filetype ?? 'docx';
    $filepath = $filepath ?? '';
    $slug     = $slug ?? 'ddd';

    switch ($filetype) {
        case 'pdf':
            $label = 'PDF file:';
            $iframeSrc = str_replace('\\', '/', $filepath);
            break;
        case 'doc':
        case 'docx':
        default:
            $label = 'Word file:';
            $iframeSrc = route('view-document', [ 'file' => $filepath ]);
            break;
    };

    // get download link
    if (!empty($filepath)) {
        $downloadLink = view('admin.components.link', [
            'name'   => '<i class="fa-solid fa-download"></i>',
            'src'    => route('download-from-public',
                            [
                                'file' => $filepath,
                                'name' => $slug
                            ]
                        ),
            'target' => '_blank',
            'class'  => 'resume-download',
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
<div @if(!empty($classes))
         class="{!! implode(' ', $classes) !!}"
     @endif
     @if(!empty($styles))
         style="{!! implode(' ', $styles) !!}"
     @endif
>
    <div class="column is-2 label" style="min-width: 6rem;">
        @if(!empty($label))
            <strong>{!! $label !!}</strong>
        @endif
    </div>
    <div class="column is-10 value">

        @if(!empty($iframeSrc))

            <div style="flex: 1; padding: 5px;">
                <iframe src="{{ $iframeSrc }}"
                        style="width:100%; min-height:300px; border: 1px solid #ccc;">
                </iframe>
            </div>

        @endif

    </div>
</div>
