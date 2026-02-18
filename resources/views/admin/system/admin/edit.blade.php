@php
    use App\Models\System\Admin;
    use App\Models\System\AdminTeam;
    use App\Models\System\Country;
    use App\Models\System\EmploymentStatus;
    use App\Models\System\State;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Admins',          'href' => route('admin.system.admin.index') ],
        [ 'name' => $owner->name ]
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin.index') ])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? $owner->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
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

        <form action="{{ route('admin.system.admin.update', array_merge([$owner], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $owner->id
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'admin_team_id',
                'label'   => 'team',
                'value'   => old('admin_team_id') ?? $owner->team['id'] ?? $owner->team_id,
                'list'    => new AdminTeam()->listOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'username',
                'label'     => 'user name',
                'value'     => old('username') ?? $owner->username,
                'required'  => true,
                'minlength' => 6,
                'maxlength' => 200,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $owner->name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'label',
                'label'     => 'label (displayed in url)',
                'value'     => old('label') ??  $owner->label,
                'minlength' => 6,
                'maxlength' => 200,
                'required'  => true,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'salutation',
                'value'   => old('salutation') ?? $owner->salutation,
                'list'    => new Admin()->salutationListOptions(true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('role') ?? $owner->title,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'role',
                'value'     => old('role') ?? $owner->role,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'employer',
                'value'     => old('employer') ?? $owner->employer,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'employment_status_id',
                'label'   => 'employment status',
                'value'   => old('employment_status_id') ?? $owner->employment_status_id,
                'list'    => new EmploymentStatus()->listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
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
                'type'      => 'tel',
                'name'      => 'phone',
                'value'     => old('phone') ?? $owner->phone,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'email',
                'name'      => 'email',
                'value'     => old('email') ?? $owner->email,
                'required'  => true,
                'disabled'  => true,
                'maxlength' => 255,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'birthday',
                'value'   => old('birthday') ?? $owner->birthday,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $owner->link,
                'name' => old('link_name') ?? $owner->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'bio',
                'id'      => 'inputEditor',
                'value'   => old('bio') ?? $owner->bio,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $owner->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $owner->image,
                'credit'  => old('image_credit') ?? $owner->image_credit,
                'source'  => old('image_source') ?? $owner->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $owner->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $owner->public,
                'readonly'    => old('readonly') ?? $owner->readonly,
                'root'        => old('root')     ?? $owner->root,
                'disabled'    => old('disabled') ?? $owner->disabled,
                'demo'        => old('demo')     ?? $owner->demo,
                'sequence'    => old('sequence') ?? $owner->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'requires_relogin',
                'label'           => 'requires re-login',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('requires_relogin') ?? $owner->requires_relogin,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.system.admin.index')
            ])

        </form>

    </div>

@endsection
