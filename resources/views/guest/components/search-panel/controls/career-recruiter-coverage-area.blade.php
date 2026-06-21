@php
    $local         = boolval($local ?? 0);
    $regional      = boolval($regional ?? 0);
    $national      = boolval($national ?? 0);
    $international = boolval($international ?? 0);
@endphp
<div class="card" style="max-width: 28rem;">

    <div class="card-header pr-2 pl-2 pt-1 pb-1">
        <span title="Coverage Areas"><strong>coverage</strong></span>
    </div>
    <div class="card-body pr-2 pl-2 pt-1 pb-0">

        @include('guest.components.form-checkbox', [
            'name'     => 'local',
            'value'    => 1,
            'checked'  => $local,
            'nohidden' => true,
        ])

        @include('guest.components.form-checkbox', [
            'name'     => 'regional',
            'value'    => 1,
            'checked'  => $regional,
            'nohidden' => true,
        ])

        @include('guest.components.form-checkbox', [
            'name'     => 'national',
            'value'    => 1,
            'checked'  => $national,
            'nohidden' => true,
        ])

        @include('guest.components.form-checkbox', [
            'name'     => 'international',
            'value'    => 1,
            'checked'  => $international,
            'nohidden' => true,
        ])

    </div>

</div>
