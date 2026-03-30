@php
    $previewImage = getShareImage($preview_image ?? 'default.png');
@endphp
@if(!empty($previewImage))
    <div style="width: 0; height: 0;">
        <img src="{{ $previewImage }}?{{ appTimestamp() }}" alt="{{ config('app.name') }} preview image" />
    </div>
@endif
