@php
    $guest = $guest ?? 0;
    $user  = $user ?? 0;
    $admin = $admin ?? 0;
@endphp
<div class="field is-horizontal">
    <div class="field-label is-normal">
        <strong>environments</strong>
    </div>
    <div class="field-body">
        <div class="field" style="flex-grow: 0;">

            <div class="checkbox-container card form-container p-4">

                @include('guest.components.form-checkbox', [
                    'name'            => 'guest',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $guest ?? 0,
                    'message'         => $message ?? '',
                ])

                @include('guest.components.form-checkbox', [
                    'name'            => 'user',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $user ?? 0,
                    'message'         => $message ?? '',
                ])

                @include('guest.components.form-checkbox', [
                    'name'            => 'admin',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => $admin ?? 0,
                    'message'         => $message ?? '',
                ])

            </div>

        </div>
    </div>
</div>
