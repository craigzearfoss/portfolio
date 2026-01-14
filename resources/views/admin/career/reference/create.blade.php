@extends('admin.layouts.default', [
    'title'         => $title ?? 'Add New Reference',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'References',      'href' => route('admin.career.reference.index') ],
        [ 'name' => 'Add' ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.reference.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.reference.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.reference.index')
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => Auth::guard('admin')->user()->id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? '',
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'friend',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('friend') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'family',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('family') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'coworker',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('coworker') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'supervisor',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('supervisor') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'subordinate',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('subordinate') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'professional',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('professional') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'other',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('other') ?? 0,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-select-horizontal', [
                'name'    => 'company_id',
                'label'   => 'company',
                'value'   => old('company_id') ?? '',
                'list'    => \App\Models\Career\Company::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? '',
                'street2'    => old('street') ?? '',
                'city'       => old('city') ?? '',
                'state_id'   => old('state_id') ?? '',
                'states'     =>  \App\Models\System\State::listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? '',
                'country_id' => old('country_id') ?? '',
                'countries'  => \App\Models\System\Country::listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? '',
                'longitude' => old('longitude') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone' => old('phone') ?? '',
                'label' => old('phone_label') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone'   => old('alt_phone') ?? '',
                'label'   => old('alt_phone_label') ?? '',
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('email') ?? '',
                'label'   => old('email_label') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('alt_email') ?? '',
                'label'   => old('alt_email_label') ?? '',
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'birthday',
                'value'   => old('birthday') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? '',
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? '',
                'credit'  => old('image_credit') ?? '',
                'source'  => old('image_source') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'root'     => old('root') ?? 0,
                'readonly' => old('readonly') ?? 0,
                'root'     => old('root') ?? 0,
                'disabled' => old('disabled') ?? 0,
                'demo'     => old('demo') ?? 0,
                'sequence' => old('sequence') ?? 0,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Reference',
                'cancel_url' => referer('admin.career.reference.index')
            ])

        </form>

    </div>

@endsection
