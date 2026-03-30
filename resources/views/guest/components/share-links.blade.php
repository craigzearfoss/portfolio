@php
    $preview_image = $preview_image ?? 'default.png';
@endphp
@if($previewImage = getShareImage($preview_image))
    <div style="width: 0; height: 0;">
        <img src="{{ getShareImage($previewImage) }}" alt="{{ config('app.name') }} preview image" />
    </div>
@endif
