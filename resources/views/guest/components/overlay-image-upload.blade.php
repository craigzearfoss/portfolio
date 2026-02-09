@php
    $accept = $accept ?? [];
    $maxFileSize = !empty($maxFileSize) ? $maxFileSize : config('app.upload_max_file_size')
@endphp

@if(config('app.upload_enabled'))

    <form name="{{ $name ?? 'frmImageUpload' }}" action="{!! $action ?? '' !!}" method="POST" enctype="multipart/form-data">
        @csrf

        @if(!empty($maxFileSize))
            @include('admin.components.form-hidden', [
                'type' => 'hidden',
                'name' => 'MAX_FILE_SIZE',
                'value' => 1000 * $maxFileSize
            ])
        @endif

        @include('admin.components.form-image-upload', [
            'image'   => $file ?? '',
            'credit'  => $credit ?? '',
            'source'  => $source ?? '',
            'accept'  => $accept ?? [],
            'text'    => 'Recommended size 300px by 400px. (WxH)',
            'message' => $message ?? '',
        ])

        <div class="mb-3">
            <label class="form-label" for="inputImage">Image:</label>
            <input type="file"
                   name="image"
                   id="inputImage"
                   class="form-control @error('image') is-invalid @enderror"
                   accept="{{ is_array($accept) ? implode(',', $accept) : $accept }}"
            >

            @error('image')
                <span class="text-danger">{{ $message ?? '' }}</span>
            @enderror

        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Upload</button>
        </div>
    </form>

@endif
