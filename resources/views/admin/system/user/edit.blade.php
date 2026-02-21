@php
    use App\Models\System\Country;
    use App\Models\System\State;
    use App\Models\System\User;
    use App\Models\System\UserTeam;

    $userModel = new User();

    $title    = $pageTitle ?? 'User: ' . $user->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => $user->name,       'href' => route('admin.system.user.show', $user->id) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.system.user.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.user.update', array_merge([$user], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.user.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $user->id
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'user_team_id',
                'label'   => 'team',
                'value'   => old('user_team_id') ?? $user->team['id'] ?? $user->team_id,
                'list'    => new UserTeam()->listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'username',
                'label'     => 'user name',
                'value'     => old('username') ?? $user->username,
                'required'  => true,
                'minlength' => 6,
                'maxlength' => 255,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $user->name,
                'required'  => true,
                'minlength' => 6,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'label',
                'label'     => 'label (displayed in url)',
                'value'     => old('label') ??  $user->label,
                'minlength' => 6,
                'maxlength' => 200,
                'required'  => true,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'salutation',
                'value'   => old('salutation') ?? $user->salutation,
                'list'    => $userModel->salutationListOptions(true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('role') ?? $user->title,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'role',
                'value'     => old('role') ?? $user->role,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'employer',
                'value'     => old('employer') ?? $user->employer,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? $user->street,
                'street2'    => old('street2') ?? $user->street2,
                'city'       => old('city') ?? $user->city,
                'state_id'   => old('state_id') ?? $user->state_id,
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $user->zip,
                'country_id' => old('country_id') ?? $user->country_id,
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $user->latitude,
                'longitude' => old('longitude') ?? $user->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'tel',
                'name'      => 'phone',
                'value'     => old('phone') ?? $user->phone,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'email',
                'name'      => 'email',
                'value'     => old('email') ?? $user->email,
                'required'  => true,
                'disabled'  => true,
                'maxlength' => 255,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'birthday',
                'value'   => old('birthday') ?? $user->birthday,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $user->link,
                'name' => old('link_name') ?? $user->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'bio',
                'id'      => 'inputEditor',
                'value'   => old('bio') ?? $user->bio,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $user->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $user->image,
                'credit'  => old('image_credit') ?? $user->image_credit,
                'source'  => old('image_source') ?? $user->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $user->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'status',
                'value'   => old('status') ?? $user->status,
                'list'    => $userModel->statusListOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? $user->public,
                'readonly'    => old('readonly') ?? $user->readonly,
                'root'        => old('root')     ?? $user->root,
                'disabled'    => old('disabled') ?? $user->disabled,
                'demo'        => old('demo')     ?? $user->demo,
                'sequence'    => old('sequence') ?? $user->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.user.index')
            ])

        </form>

    </div>

@endsection

