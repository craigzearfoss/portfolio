@php
    use App\Enums\EnvTypes;
@endphp
<div class="floating-div-container">
    <div class="show-container card floating-div">

        <h2 class="title has-text-centered">Contact Us</h2>

        @if(!config('app.contactable'))

            <h3 class="subtitle p-4">Sorry, but we are not currently accepting messages.</h3>

        @else

            <form action="{{ $envType == EnvTypes::ADMIN
                                    ? route('admin.contact.storeContactMessage')
                                    : route('guest.contact.storeContactMessage') }}"
                  method="POST"
            >
                @csrf

                @include($envType == EnvTypes::ADMIN
                                        ? 'admin.components.form-input-horizontal'
                                        : 'guest.components.form-input-horizontal',
                [
                    'name'        => 'name',
                    'value'       => old('name') ?? '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'style'       => 'width: 30rem;',
                    'placeholder' => 'Your Name',
                    'message  '   => $message ?? '',
                ])

                @include($envType == EnvTypes::ADMIN
                                        ? 'admin.components.form-input-horizontal'
                                        : 'guest.components.form-input-horizontal',
                [
                    'type'        => 'email',
                    'name'        => 'email',
                    'value'       => old('email') ?? '',
                    'required'    => true,
                    'maxlength'   => 255,
                    'style'       => 'width: 30rem;',
                    'placeholder' => 'name@example.com',
                    'message  '   => $message ?? '',
                ])

                @include($envType == EnvTypes::ADMIN
                                        ? 'admin.components.form-input-horizontal'
                                        : 'guest.components.form-input-horizontal',
                [
                    'name'        => 'subject',
                    'value'       => old('subject') ?? '',
                    'required'    => true,
                    'maxlength'   => 500,
                    'style'       => 'width: 30rem;',
                    'placeholder' => 'Subject',
                    'message  '   => $message ?? '',
                ])

                @include($envType == EnvTypes::ADMIN
                                        ? 'admin.components.form-textarea-horizontal'
                                        : 'guest.components.form-textarea-horizontal',
                [
                    'name'        => 'body',
                    'value'       => old('body') ?? '',
                    'required'    => true,
                    'cols'        => 60,
                    'placeholder' => 'Your Message',
                    'message  '   => $message ?? '',
                ])

                <div class="mt-2" style="float: right;">

                    @include($envType == EnvTypes::ADMIN
                            ? 'admin.components.form-button-submit'
                            : 'guest.components.form-button-submit',
                    [
                        'label'      => 'Submit',
                        'cancel_url' => $envType == EnvTypes::ADMIN
                                            ? route('admin.dashboard')
                                            : route('guest.index')
                    ])

                </div>

            </form>

        @endif

    </div>
</div>
