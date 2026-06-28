@php
    $founded_min = $founded_min ?? request()->query('founded_min');
    $founded_max = $founded_max ?? request()->query('founded_max');
@endphp
<div class="pl-2">
    <div style="display: inline-block; width: 4rem; vertical-align: top;">
        <span><strong>founded</strong></span>
    </div>
    <div style="display: inline-block; width: 6rem;">
        <div class="search-form-control" style="display: inline-block;">
            @include('guest.components.input', [
                'type'        => 'number',
                'name'        => 'founded-min',
                'label'       => null,
                'value'       => $founded_min,
                'placeholder' => 'from',
                'message'     => $message ?? '',
                'class'       => [ 'submit-search-on-enter-key' ],
                'style'       => [ 'width: 5rem', 'height: 1.8em !important', 'font-size: .9rem' ],
            ])
        </div>
        <div class="search-form-control" style="display: inline-block;">
            @include('guest.components.input', [
                'type'        => 'number',
                'name'        => 'founded-max',
                'label'       => null,
                'value'       => $founded_max,
                'message'     => $message ?? '',
                'placeholder' => 'to',
                'class'       => [ 'submit-search-on-enter-key' ],
                'style'       => [ 'width: 5rem', 'height: 1.8em !important', 'font-size: .9rem' ],
            ])
        </div>
    </div>
</div>
