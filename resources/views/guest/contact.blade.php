@extends('guest.layouts.default', [
    'pageTitle'   => 'Contact Us',
    'title'       => '',
    'subtitle'    => null,
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('system.homepage')],
        [ 'name' => 'Contact Us']
    ],
    'buttons' => [],
    'errorMessages' => !empty($errors->get('GLOBAL'))
        ? [$errors->get('GLOBAL')] : ['Please fix the indicated problems before submitting.'],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <h2 class="title">Contact Us</h2>

        @if(empty(config('app.contactable')))

            <h3 class="subtitle p-4">Sorry, but we are not currently accepting messages.</h3>

        @else

            <form action="{{ route('system.contact.storeMessage') }}" method="POST">
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
                        'placeholder' => 'nam@example.com',
                        'message  '   => $message ?? '',
                    ])

                    @include('guest.components.form-input-horizontal', [
                        'name'        => 'subject',
                        'value'       => old('subject') ?? '',
                        'required'    => true,
                        'maxlength'   => 255,
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
                        'cancel_url' => route('system.homepage')
                    ])

                </div>

            </form>

        @endif

    </div>

@endsection
