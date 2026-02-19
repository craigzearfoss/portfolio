@php
    use App\Models\System\Country;
    use App\Models\System\State;
    use App\Models\System\User;
    use App\Models\System\UserTeam;

    $userModel = new User();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Add New User',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => 'Add' ],
    ],
    'buttons'          => [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.user.index')])->render(),
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

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.user.store', request()->all()) }}" method="POST">
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
                        'style'     => 'text-transform: lowercase',
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
                        'style'     => 'text-transform: lowercase',
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'    => 'user_team_id',
                        'label'   => 'team',
                        'value'   => old('user_team_id') ?? '',
                        'list'    => new UserTeam()->listOptions([], 'id', 'name', true),
                        'message' => $message ?? '',
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
                'name'    => 'salutation',
                'value'   => old('salutation') ?? '',
                'list'    => $userModel->salutationListOptions(true),
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
                'street'     => old('street') ?? $owner->street,
                'street2'    => old('street2') ?? $owner->street2,
                'city'       => old('city') ?? $owner->city,
                'state_id'   => old('state_id') ?? $owner->state_id,
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $owner->zip,
                'country_id' => old('country_id') ?? $owner->country_id,
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $owner->latitude,
                'longitude' => old('longitude') ?? $owner->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? '',
                'maxlength' => 20,
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

            @include('admin.components.form-select-horizontal', [
                'name'    => 'status',
                'value'   => old('status') ?? 0,
                'list'    => $userModel->statusListOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? 0,
                'readonly'    => old('readonly') ?? 0,
                'root'        => old('root')     ?? 0,
                'disabled'    => old('disabled') ?? 0,
                'demo'        => old('demo')     ?? 0,
                'sequence'    => old('sequence') ?? 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Create User',
                'cancel_url' => referer('admin.system.user.index')
            ])

        </form>

    </div>

@endsection
