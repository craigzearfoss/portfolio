@extends('admin.layouts.default', [
    'title' =>'Add a Contact to ' . $company->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Companies',       'href' => route('admin.career.company.index') ],
        [ 'name' => $company->name,    'href' => route('admin.career.company.show', $company) ],
        [ 'name' => 'Add Contact' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => route('admin.career.company.show', $company) ],
    ],
    'errorMessages' => $errors->all(),
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div id="contact-select" class="edit-container card form-container p-2">

        <form action="{{ route('admin.career.company.contact.attach', $company) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => route('admin.career.company.show', $company)
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'contact_id',
                'label'    => 'contact',
                'value'    => old('contact_id') ?? '',
                'list'     => \App\Models\Career\Contact::listOptions([], 'id', 'name', true),
                'onchange' => "if (this.value) { document.getElementById('new-contact').style.display='none'; } else { document.getElementById('new-contact').style.display='block'; }",
                'message'  => $message ?? '',
            ])

            <div id="new-contact" class="edit-container card form-container p-4">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'      => 'title',
                    'value'     => old('title') ?? '',
                    'list'      => \App\Models\User::titleListOptions([], true, true),
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'    => 'job_title',
                    'label'   => 'job title',
                    'value'   => old('job_title') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'street',
                    'value'     => old('street') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'street2',
                    'value'     => old('street2') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'city',
                    'value'     => old('city') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'state_id',
                    'label'   => 'state',
                    'value'   => old('state_id') ?? '',
                    'list'    => \App\Models\State::listOptions([], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'zip',
                    'value'     => old('zip') ?? '',
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'country_id',
                    'label'   => 'country',
                    'value'   => old('country_id') ?? '',
                    'list'    => \App\Models\Country::listOptions([], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'latitude',
                    'value'     => old('latitude') ?? '',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'longitude',
                    'value'     => old('longitude') ?? '',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'phone',
                    'value'     => old('phone') ?? '',
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'phone_label',
                    'label'     => 'phone label',
                    'value'     => old('phone_label') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_phone',
                    'label'     => 'alt phone',
                    'value'     => old('alt_phone') ?? '',
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_phone_label',
                    'label'     => 'alt phone label',
                    'value'     => old('alt_phone_label') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'email',
                    'value'     => old('email') ?? '',
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'email_label',
                    'label'     => 'email label',
                    'value'     => old('email_label') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_email',
                    'label'     => 'alt email',
                    'value'     => old('alt_email') ?? '',
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_email_label',
                    'label'     => 'alt email label',
                    'value'     => old('alt_email_label') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

            </div>

            @include('admin.components.form-button-submit', [
                'label'      => 'Add Contact',
                'cancel_url' => referer('admin.career.company.show', $company)
            ])

        </form>

    </div>

@endsection
