@extends('guest.layouts.default', [
    'title'    => 'Contact',
    'subtitle' => null,
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('guest.homepage')],
        [ 'name' => 'Contact']
    ],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <h2 class="title">Contact Us</h2>

            <form action="{{ route('guest.database.store') }}" method="POST">
                @csrf

                <div class="column is-6">

                    @include('guest.components.form-input-horizontal', [
                        'name'        => 'name',
                        'value'       => old('name') ?? '',
                        'unique'      => true,
                        'maxlength'   => 255,
                        'placeholder' => 'Your Name',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-input-horizontal', [
                        'type'        => 'email',
                        'name'        => 'email',
                        'value'       => old('email') ?? '',
                        'unique'      => true,
                        'maxlength'   => 255,
                        'placeholder' => 'nam@example.com',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-input-horizontal', [
                        'name'        => 'subject',
                        'value'       => old('subject') ?? '',
                        'unique'      => true,
                        'maxlength'   => 255,
                        'placeholder' => 'Subject',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-textarea-horizontal', [
                        'name'        => 'body',
                        'value'       => old('body') ?? '',
                        'unique'      => true,
                        'maxlength'   => 255,
                        'placeholder' => 'Your Message',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-button-submit-horizontal', [
                        'label'      => 'Submit',
                        'cancel_url' => route('guest.homepage')
                    ])

                </div>

            </form>

    </div>

@endsection
