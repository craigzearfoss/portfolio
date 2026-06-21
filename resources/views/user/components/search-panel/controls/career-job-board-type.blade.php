@php
    $free      = boolval($free ?? 0);
    $premium   = boolval($premium ?? 0);
    $staffing  = boolval($staffing ?? 0);
    $freelance = boolval($freelance ?? 0);
@endphp
<div class="card" style="max-width: 28rem;">

    <div class="card-body pr-2 pl-2 pt-1 pb-0">

        @include('user.components.form-checkbox', [
            'name'     => 'free',
            'value'    => 1,
            'checked'  => $free,
            'nohidden' => true,
        ])

        @include('user.components.form-checkbox', [
            'name'     => 'premium',
            'value'    => 1,
            'checked'  => $premium,
            'nohidden' => true,
        ])

        @include('user.components.form-checkbox', [
            'name'     => 'staffing',
            'value'    => 1,
            'checked'  => $staffing,
            'nohidden' => true,
        ])

        @include('user.components.form-checkbox', [
            'name'     => 'freelance',
            'value'    => 1,
            'checked'  => $freelance,
            'nohidden' => true,
        ])

    </div>

</div>
