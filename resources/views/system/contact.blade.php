@extends('guest.layouts.default', [
    'title'         => 'Contact Us',
    'subtitle'      => null,
    'breadcrumbs'   => [
        [ 'name' => 'Home', 'href' => route('home')],
        [ 'name' => 'Contact Us']
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    <div class="card p-4">

        <h2 class="title">Contact Us</h2>

        @if(!config('app.contactable'))

            <h3 class="subtitle p-4">Sorry, but we are not currently accepting messages.</h3>

        @else

            <form action="{{ route('contact.storeMessage') }}" method="POST">
                @csrf

                <div class="column is-6">

                    @include('guest.components.form-input-horizontal', [
                        'name'        => 'name',
                        'value'       => old('name') ?? '',
                        'required'    => true,
                        'maxlength'   => 255,
                        'placeholder' => 'Your Name',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-input-horizontal', [
                        'type'        => 'email',
                        'name'        => 'email',
                        'value'       => old('email') ?? '',
                        'required'    => true,
                        'maxlength'   => 255,
                        'placeholder' => 'name@example.com',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-input-horizontal', [
                        'name'        => 'subject',
                        'value'       => old('subject') ?? '',
                        'required'    => true,
                        'maxlength'   => 500,
                        'placeholder' => 'Subject',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-textarea-horizontal', [
                        'name'        => 'body',
                        'value'       => old('body') ?? '',
                        'required'    => true,
                        'maxlength'   => 255,
                        'placeholder' => 'Your Message',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-button-submit-horizontal', [
                        'label'      => 'Submit',
                        'cancel_url' => route('home')
                    ])

                </div>

            </form>

        @endif

    </div>

@endsection
