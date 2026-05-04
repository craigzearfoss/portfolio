@php
    if (empty($resource)) {
        abort(500, 'No $resource parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'button-upload-document.blade.php.');
    }

    if (empty($column)) {
        abort(500, 'No $column parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'button-upload-document.blade.php.');
    }

    $target_data = $target_data ?? null;
    if (empty($target_data)) {
        abort(500, 'No $dataTarget parameter specified in ' . base_path() . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'button-upload-document.blade.php.');
    }

    // get the accepted file types
    $accept = !empty($accept)
        ? is_array($accept) ? $accept : explode(',', $accept)
        : [];
    if (empty($accept)) {
        $accept = config('app.upload_document_accept');
    }

    $resourceName = $resource->name ?? $resource->title ?? $resource->label ??
        (substr(strrchr(get_class($resource), '\\'), 1) . ' ' . $resource->id);

    $modalTitle = $modalTitle ?? (!empty($resource->{$column}) ? 'Replace ' : 'Upload ') .  ' ' . $resourceName . ' ' .  $column;
    $label = $label ?? 'Upload';
    $message = $message ?? '';

    // get classes
    $class = !empty($class)
        ? is_array($class) ? $class : explode(' ', $class)
        : [];
    $class = array_unique(array_merge(['js-modal-trigger button is-small is-gray my-0 nav-button'], $class));
    if (!empty($selected)) {
        $class[] = array_unique(array_merge(['selected'], $class));
    }

    // get styles
    $style = !empty($style)
        ? is_array($style) ? $style : explode(' ', $style)
        : [];
    $style[] = 'margin: 0 0 0.5rem 0.5rem !important';
@endphp
<button
    @if (!empty($class))
        class="{{ implode(' ', $class) }}"
    @endif
    @if (!empty($style))
        style="{{ implode('; ', $style) }};"
    @endif
    data-target="{{ $target_data }}"
>
    <i class="fa fa-upload"></i>
    {{ $label }}
</button>

<div id="{{ $target_data }}" class="modal">

    <div class="modal-background"></div>
    <div class="modal-card">

        <form action="{{ route('guest.file.store') }}" method="POST" enctype="multipart/form-data">

            <header class="modal-card-head">
                <p class="modal-card-title" style="margin-bottom: 0 !important; font-size: 1.2rem; font-weight: 700;" >{{ $modalTitle }}</p>
                <button class="delete cancel-file-upload-modal" aria-label="close"></button>
            </header>
            <section class="modal-card-body">

                @csrf

                <div class="mb-3">

                    <div style="display: none;">

                        <label class="form-label" for="inputUploadType">upload_type</label>
                        <input type="text" id="inputUploadType" name="upload_type" value="document">

                        <label class="form-label" for="inputResourceType">resource_type_id</label>
                        <input type="text" id="inputResourceTypeId" name="resource_type_id" value="{{ $resource->resource_type_id }}">

                        <label class="form-label" for="artId">resource_id</label>
                        <input type="text" id="inputResourceId" name="resource_id" value="{{ $resource->id }}">

                        <label class="form-label" for="artId">column</label>
                        <input type="text" id="inputColumn" name="column" value="{{ $column }}">

                    </div>

                    <label class="form-label" for="inputFile">File:</label>
                    <input
                        type="file"
                        name="file"
                        id="inputFile"
                        class="form-control button is-small is-gray my-0 nav-button @error('file') is-invalid @enderror"
                        @if (!empty($accept))
                            accept="{{ implode(',', array_map(function($val) { $val = trim($val, ' ,'); return '.' . $val; }, $accept)) }}"
                        @endif
                    >
                    @error('file')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </section>
            <footer class="modal-card-foot">
                <div class="buttons">
                    <button class="cancel-file-upload-modal button is-small is-dark my-0 nav-button">
                        <i class="fa fa-ban"></i>Cancel
                    </button>
                    <button type="submit" class="button is-small is-dark my-0 nav-button">
                        <i class="fa fa-save"></i>Upload
                    </button>
                </div>
            </footer>

        </form>

    </div>
</div>
