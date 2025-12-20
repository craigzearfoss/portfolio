@extends('admin.layouts.default', [
    'title'         => 'Add New User',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => 'Add' ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.system.user.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.user.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user.index')
            ])

            <div class="card p-4">
                <div class="card-body p-4">

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'username',
                        'label'     => 'user name',
                        'value'     => old('username') ?? '',
                        'required'  => true,
                        'minlength' => 6,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'name',
                        'value'     => old('name') ?? '',
                        'required'  => true,
                        'minlength' => 6,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'label',
                        'label'     => 'label (displayed in url)',
                        'value'     => old('label') ??  '',
                        'minlength' => 6,
                        'maxlength' => 200,
                        'required'  => true,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'    => 'user_team_id',
                        'label'   => 'team',
                        'value'   => old('user_team_id') ?? '',
                        'list'    => \App\Models\System\UserTeam::listOptions(),
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'      => 'email',
                        'name'      => 'email',
                        'value'     => old('email') ?? '',
                        'required'  => true,
                        'maxlength' => 255,
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
            </div>

            @include('admin.components.form-select-horizontal', [
                'name'    => 'title',
                'value'   => old('title') ?? '',
                'list'    => \App\Models\System\User::titleListOptions([], true, true),
                'message' => $message ?? '',
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
                'street'     => old('street') ?? $admin->street,
                'street2'    => old('street2') ?? $admin->street2,
                'city'       => old('city') ?? $admin->city,
                'state_id'   => old('state_id') ?? $admin->state_id,
                'states'     => \App\Models\System\State::listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $admin->zip,
                'country_id' => old('country_id') ?? $admin->country_id,
                'countries'  => \App\Models\System\Country::listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $admin->latitude,
                'longitude' => old('longitude') ?? $admin->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? '',
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'website',
                'value'     => old('website') ?? '',
                'maxlength' => 255,
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

            @include('admin.components.form-file-upload-horizontal', [
                'name'    => 'thumbnail',
                'value'   => old('thumbnail') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'status',
                'value'   => old('status') ?? 0,
                'list'    => \App\Models\System\User::statusListOptions(),
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
                'label'      => 'Add User',
                'cancel_url' => referer('admin.system.user.index')
            ])

        </form>

    </div>

@endsection
