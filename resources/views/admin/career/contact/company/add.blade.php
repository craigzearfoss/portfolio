@php
    use App\Models\Career\Company;
    use App\Models\System\Country;
    use App\Models\Career\Industry;
    use App\Models\System\State;
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Add a Company to ' . $contact->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Contacts',        'href' => route('admin.career.contact.index') ],
        [ 'name' => $contact->name,    'href' => route('admin.career.contact.show', $contact) ],
        [ 'name' => 'Add Company' ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.contact.index')])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
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
                'list'     => new Company()->listOptions([], 'id', 'name', true),
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
                    'list'    => new Industry()->listOptions([], 'id', 'name', true, true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-location-horizontal', [
                    'street'     => old('street') ?? '',
                    'street2'    => old('street2') ?? '',
                    'city'       => old('city') ?? '',
                    'state_id'   => old('state_id') ?? '',
                    'states'     => new State()->listOptions([], 'id', 'name', true),
                    'zip'        => old('zip') ?? '',
                    'country_id' => old('country_id') ?? '',
                    'countries'  => new Country()->listOptions([], 'id', 'name', true),
                    'message'    => $message ?? '',
                ])

                @include('admin.components.form-coordinates-horizontal', [
                    'latitude'  => old('latitude') ?? '',
                    'longitude' => old('longitude') ?? '',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'phone',
                    'value'     => old('phone') ?? '',
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'phone_label',
                    'label'     => 'phone label',
                    'value'     => old('phone_label') ?? '',
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_phone',
                    'label'     => 'alt phone',
                    'value'     => old('alt_phone') ?? '',
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_phone_label',
                    'label'     => 'alt phone label',
                    'value'     => old('alt_phone_label') ?? '',
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'email',
                    'value'     => old('email') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'email_label',
                    'label'     => 'email label',
                    'value'     => old('email_label') ?? '',
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_email',
                    'label'     => 'alt email',
                    'value'     => old('alt_email') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'alt_email_label',
                    'label'     => 'alt email label',
                    'value'     => old('alt_email_label') ?? '',
                    'maxlength' => 100,
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
