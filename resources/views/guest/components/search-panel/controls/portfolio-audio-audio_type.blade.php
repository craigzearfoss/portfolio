@php
    use App\Models\Portfolio\Audio;
    $audio_type = $audio_type ?? request()->query('audio_type');

    $types = [ '' => '' ];

    foreach (Audio::AUDIO_TYPES as $type) {
        $types[$type] = $type;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'audio_type',
        'label'    => 'type',
        'value'    => $audio_type,
        'list'     => $types,
        'style'    => 'width: 8rem;'
    ])
</div>
