@extends('admin.layouts.default', [
    'title' =>'Add a Company to ' . $contact->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Contacts',       'href' => route('admin.career.contact.index') ],
        [ 'name' => $contact->name,    'href' => route('admin.career.contact.show', $contact) ],
        [ 'name' => 'Add Company' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => route('admin.career.contact.show', $contact) ],
    ],
    'errorMessages' =>  $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div id="company-select" class="edit-container card form-container p-2">

        <form action="{{ route('admin.career.contact.company.attach', $contact) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => route('admin.career.contact.show', $contact)
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'company_id',
                'label'    => 'company',
                'value'    => old('company_id') ?? '',
                'list'     => \App\Models\Career\Company::listOptions([], 'id', 'name', true),
                'onchange' => "if (this.value) { document.getElementById('new-company').style.display='none'; } else { document.getElementById('new-company').style.display='block'; }",
                'message'  => $message ?? '',
            ])

            <div id="new-company" class="card form-container p-4">

                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $contact->owner['id'] ?? ''
                ])

                @include('admin.components.form-hidden', [
                    'name'  => 'contact_id',
                    'value' => $contact->id
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'industry_id',
                    'label'   => 'industry',
                    'value'   => old('industry_id') ?? 0,
                    'list'    => \App\Models\Career\Industry::listOptions([], true, false, true),
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
                'label'      => 'Add Company',
                'cancel_url' => referer('admin.career.contact.show', $contact)
            ])

        </form>

    </div>

@endsection
