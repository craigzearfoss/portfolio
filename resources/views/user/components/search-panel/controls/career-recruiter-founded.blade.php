@php
    $founded_min = $founded_min ?? request()->query('founded_min');
    $founded_max = $founded_max ?? request()->query('founded_max');
@endphp
<div class="pl-2">
    <span><strong>founded</strong></span>
    <div class="search-form-control" style="display: inline-block;">
        @include('user.components.input', [
            'type'        => 'number',
            'name'        => 'founded-min',
            'label'       => null,
            'value'       => $founded_min,
            'placeholder' => 'from',
            'message'     => $message ?? '',
            'class'       => [ 'submit-search-on-enter-key' ],
            'style'      => [ 'width: 3.5rem' ],
        ])
    </div>
    <div class="search-form-control" style="display: inline-block;">
        @include('user.components.input', [
            'type'        => 'number',
            'name'        => 'founded-max',
            'label'       => null,
            'value'       => $founded_max,
            'message'     => $message ?? '',
            'placeholder' => 'to',
            'class'       => [ 'submit-search-on-enter-key' ],
            'style'       => [ 'width: 3.5rem' ],
        ])
    </div>
</div>
