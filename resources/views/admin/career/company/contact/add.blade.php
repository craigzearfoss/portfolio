@php
    use App\Models\System\Country;
    use App\Models\System\State;
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Add a Contact to ' . $company->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Companies',       'href' => route('admin.career.company.index') ],
        [ 'name' => $company->name,    'href' => route('admin.career.company.show', $company) ],
        [ 'name' => 'Add Contact' ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.company.index')])->render(),
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
                    'list'      => \App\Models\System\User::titleListOptions([], true, true),
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'    => 'title',
                    'value'   => old('title') ?? '',
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
