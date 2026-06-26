@php
    $download = boolval($download ?? false);
    $external = boolval($external ?? false);

    $href = $href ?? null;
    $filename = $filename ?? '';
    if (empty($filename)) {
        abort(500, 'No $filename parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'download-links.blade.php.');
    }
@endphp
<div style="display: inline-block;">

    @if ($download)
        <a class="download-link download-link-with-prompt text-xl"
           title="download"
           data-url="{{ $href }}"
           data-filename="{{ $filename }}"
        >
            <i class="fa fa-download"></i>
        </a>
    @endif

    @if ($external)
        <a class="certificate text-xl"
           href="{{ $href }}"
           title="open in new window"
           target="_blank">
            <i class="fa fa-external-link"></i>
        </a>
    @endif

</div>
