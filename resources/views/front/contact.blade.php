@extends('front.layouts.default', [
    'title'    => 'Contact',
    'subtitle' => null,
    'breadcrumbs' => [
        [ 'name' => 'Home', 'url' => route('front.homepage')],
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

            <form action="{{ route('front.database.store') }}" method="POST">
                @csrf

                <div class="column is-6">

                    @include('front.components.form-input-horizontal', [
                        'name'        => 'name',
                        'value'       => old('name') ?? '',
                        'unique'      => true,
                        'maxlength'   => 255,
                        'placeholder' => 'Your Name',
                        'message  '   => $message ?? '',
                    ])

                    @include('front.components.form-input-horizontal', [
                        'type'        => 'email',
                        'name'        => 'email',
                        'value'       => old('email') ?? '',
                        'unique'      => true,
                        'maxlength'   => 255,
                        'placeholder' => 'nam@example.com',
                        'message  '   => $message ?? '',
                    ])

                    @include('front.components.form-input-horizontal', [
                        'name'        => 'subject',
                        'value'       => old('subject') ?? '',
                        'unique'      => true,
                        'maxlength'   => 255,
                        'placeholder' => 'Subject',
                        'message  '   => $message ?? '',
                    ])

                    @include('front.components.form-textarea-horizontal', [
                        'name'        => 'body',
                        'value'       => old('body') ?? '',
                        'unique'      => true,
                        'maxlength'   => 255,
                        'placeholder' => 'Your Message',
                        'message  '   => $message ?? '',
                    ])

                    @include('front.components.form-button-submit-horizontal', [
                        'label'      => 'Submit',
                        'cancel_url' => route('front.homepage')
                    ])

                </div>

            </form>

    </div>

@endsection
