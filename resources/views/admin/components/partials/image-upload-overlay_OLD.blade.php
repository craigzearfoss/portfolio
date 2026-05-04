@php
    use App\Services\ResourceFileService;

    if (empty($resource)) {
        abort(500, '$resource not specified in resources\views\admin\components\partials\image-upload-overlay.blade.php.');
    }
    if (empty($resource_type)) {
        abort(500, '$resource_type not specified in resources\views\admin\components\partials\image-upload-overlay.blade.php.');
    }
    if (empty($column)) {
        abort(500, '$column not specified in resources\views\admin\components\partials\image-upload-overlay.blade.php. ' .
        'Valid columns are ' .  implode(', ', ResourceFileService::IMAGE_COLUMNS) . '.');
    } elseif (!in_array($column, ResourceFileService::IMAGE_COLUMNS)) {
        abort(500, 'Invalid $column `' . $column . ' ` specified in resources\views\admin\components\partials\image-upload-overlay.blade.php. ' .
        'Valid columns are ' .  implode(', ', ResourceFileService::IMAGE_COLUMNS) . '.');
    }
@endphp

<div id="modal-js-example" class="modal">
    <div class="show-container car floating-div">
        <form action="{{ route('admin.file.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">

                <label class="form-label" for="inputUploadType">upload_type</label>
                <input type="text" id="inputUploadType" name="upload_type" value="image">

                <br>

                <label class="form-label" for="inputResourceType">resource_type_id</label>
                <input type="text" id="inputResourceTypeId" name="resource_type_id" value="{{ $resource_type->id }}">

                <br>

                <label class="form-label" for="artId">resource_id</label>
                <input type="text" id="inputResourceId" name="resource_id" value="{{ $resource->id }}">

                <br>

                <label class="form-label" for="artId">column</label>
                <input type="text" id="inputColumn" name="column" value="image">

                <br>

                <label class="form-label" for="inputFile">File:</label>
                <input
                    type="file"
                    name="file"
                    id="inputFile"
                    class="form-control @error('file') is-invalid @enderror">

                @error('file')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Upload</button>
            </div>

        </form>
    </div>
</div>
