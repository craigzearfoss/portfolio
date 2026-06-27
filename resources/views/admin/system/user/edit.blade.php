@php
    use App\Models\System\Country;
    use App\Models\System\State;
    use App\Models\System\User;
    use App\Models\System\UserTeam;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $user        = $user ?? null;
    $thisUser    = $thisUser ?? null;

    $userModel = new User();

    $title    = 'Edit ' . getResourcePageTitle($thisUser);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => $thisUser->name,   'href' => route('admin.system.user.show', $thisUser) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.user.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.system.user.update', array_merge([$thisUser], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.system.user.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $thisUser->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $thisUser->id,
                    'hide'  => !$isRootAdmin,
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'user_team_id',
                    'label'   => 'team',
                    'value'   => old('user_team_id') ?? $thisUser->team['id'] ?? $thisUser->team_id,
                    'list'    => new UserTeam()->listOptions([], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'username',
                    'label'     => 'user name',
                    'value'     => old('username') ?? $thisUser->username,
                    'required'  => true,
                    'minlength' => 6,
                    'maxlength' => 255,
                    'style'     => 'text-transform: lowercase',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $thisUser->name,
                    'required'  => true,
                    'minlength' => 6,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'label',
                    'label'     => 'label (displayed in url)',
                    'value'     => old('label') ??  $thisUser->label,
                    'minlength' => 6,
                    'maxlength' => 200,
                    'required'  => true,
                    'style'     => 'text-transform: lowercase',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'salutation',
                    'value'   => old('salutation') ?? $thisUser->salutation,
                    'list'    => $userModel->salutationListOptions(true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'    => 'date',
                    'name'    => 'birthday',
                    'value'   => old('birthday') ?? $thisUser->birthday,
                    'message' => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'title',
                    'value'     => old('role') ?? $thisUser->title,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'role',
                    'value'     => old('role') ?? $thisUser->role,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'employer',
                    'value'     => old('employer') ?? $thisUser->employer,
                    'maxlength' => 100,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-location-horizontal', [
                    'street'     => old('street') ?? $thisUser->street,
                    'street2'    => old('street2') ?? $thisUser->street2,
                    'city'       => old('city') ?? $thisUser->city,
                    'state_id'   => old('state_id') ?? $thisUser->state_id,
                    'states'     => new State()->listOptions([], 'id', 'name', true),
                    'zip'        => old('zip') ?? $thisUser->zip,
                    'country_id' => old('country_id') ?? $thisUser->country_id,
                    'countries'  => new Country()->listOptions([], 'id', 'name', true),
                    'message'    => $message ?? '',
                ])

                @include('admin.components.form-coordinates-horizontal', [
                    'latitude'  => old('latitude') ?? $thisUser->latitude,
                    'longitude' => old('longitude') ?? $thisUser->longitude,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'tel',
                    'name'      => 'phone',
                    'value'     => old('phone') ?? $thisUser->phone,
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'email',
                    'name'      => 'email',
                    'value'     => old('email') ?? $thisUser->email,
                    'required'  => true,
                    'disabled'  => true,
                    'maxlength' => 255,
                    'style'     => 'text-transform: lowercase',
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $thisUser->link,
                    'name'    => old('link_name') ?? $thisUser->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'bio',
                    'id'      => 'inputEditor',
                    'value'   => old('bio') ?? $thisUser->bio,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $thisUser->description,
                    'message' => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $thisUser->disclaimer,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 3,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-disclaimer' ],
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $thisUser,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'status',
                    'value'   => old('status') ?? $thisUser->status,
                    'list'    => $userModel->statusListOptions(),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $thisUser->is_public,
                    'is_readonly' => old('is_readonly') ?? $thisUser->is_readonly,
                    'is_root'     => old('is_root')     ?? $thisUser->root,
                    'is_disabled' => old('is_disabled') ?? $thisUser->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $thisUser->is_demo,
                    'sequence'    => old('sequence')    ?? $thisUser->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.system.user.index')
        ])

    </form>

@endsection

