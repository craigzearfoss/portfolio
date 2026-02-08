@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Add New Admin',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admins',          'href' => route('admin.system.admin.index') ],
        [ 'name' => 'Add' ]
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.admin.index')])->render(),
    ],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin.index')
            ])

            <div class="card p-4 mb-3">

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'admin_team_id',
                    'label'   => 'team',
                    'value'   => old('admin_team_id') ?? '',
                    'list'    => \App\Models\System\AdminTeam::listOptions([], true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'username',
                    'label'     => 'user name',
                    'value'     => old('username') ?? '',
                    'required'  => true,
                    'minlength' => 6,
                    'maxlength' => 200,
                    'style'     => 'text-transform: lowercase',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'label',
                    'label'     => 'label (displayed in url)',
                    'value'     => old('label') ?? '',
                    'minlength' => 6,
                    'maxlength' => 200,
                    'required'  => true,
                    'style'     => 'text-transform: lowercase',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'salutation',
                    'value'   => old('salutation') ?? '',
                    'list'    => \App\Models\System\Admin::salutationListOptions([], true, true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'title',
                    'value'     => old('role') ?? '',
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'role',
                    'value'     => old('role') ?? '',
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'employer',
                    'value'     => old('employer') ?? '',
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-location-horizontal', [
                    'street'     => old('street') ?? '',
                    'street2'    => old('street2') ?? '',
                    'city'       => old('city') ?? '',
                    'state_id'   => old('state_id') ?? '',
                    'states'     => \App\Models\System\State::listOptions([], 'id', 'name', true),
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

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'phone',
                    'value'     => old('phone') ?? '',
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'email',
                    'name'      => 'email',
                    'value'     => old('email') ?? '',
                    'required'  => true,
                    'maxlength' => 255,
                    'style'     => 'text-transform: lowercase',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'    => 'date',
                    'name'    => 'birthday',
                    'value'   => old('birthday') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-image-horizontal', [
                    'image'   => old('image') ?? '',
                    'credit'  => old('image_credit') ?? '',
                    'source'  => old('image_source') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'image_source',
                    'label'     => 'image source',
                    'value'     => old('image_source') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-file-upload-horizontal', [
                    'name'      => 'thumbnail',
                    'src'       => old('thumbnail') ?? '',
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'password',
                    'name'        => 'password',
                    'value'       => old('password') ?? '',
                    'required'    => true,
                    'minlength'   => 8,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                    'placeholder' => 'Password'
                ])

                @include('admin.components.form-input-horizontal', [
                    'label'       => 'confirm password',
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'value'       => '',
                    'required'    => true,
                    'minlength'   => 8,
                    'maxlength'   => 255,
                    'message'     => $message ?? '',
                    'placeholder' => 'Confirm Password'
                ])

            </div>

            @include('admin.components.form-settings-horizontal', [
                'root'        => old('root')     ?? 0,
                'readonly'    => old('readonly') ?? 0,
                'root'        => old('root')     ?? 0,
                'disabled'    => old('disabled') ?? 0,
                'demo'        => old('demo')     ?? 0,
                'sequence'    => old('sequence') ?? 0,
                'message'     => $message ?? '',
                'isRootAdmin' => isRootAdmin(),
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Create Admin',
                'cancel_url' => referer('admin.system.system.admin.index')
            ])

        </form>

    </div>

@endsection
