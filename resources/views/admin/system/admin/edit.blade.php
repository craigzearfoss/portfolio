@php
    use App\Models\System\Admin;
    use App\Models\System\AdminTeam;
    use App\Models\System\Country;
    use App\Models\System\EmploymentStatus;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $thisAdmin   = $thisAdmin ?? null;

    $title    = $pageTitle ?? 'Edit Admin: ' . $thisAdmin->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Admins',          'href' => route('admin.system.admin.index') ],
        [ 'name' => $thisAdmin->name,  'href' => route('admin.system.admin.profile', $thisAdmin) ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => $thisAdmin->name,  'href' => route('admin.system.admin.profile', $thisAdmin) ];
        $breadcrumbs[] = [ 'name' => 'Profile' ];
    }
    $breadcrumbs[] = [ 'name' => $thisAdmin->name,  'href' => route('admin.system.admin.show', $thisAdmin) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.system.admin.update', array_merge([$thisAdmin], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.system.admin.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $thisAdmin->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'admin_team_id',
                'label'   => 'team',
                'value'   => old('admin_team_id') ?? $thisAdmin->team['id'] ?? $thisAdmin->team_id,
                'list'    => new AdminTeam()->listOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'username',
                'label'     => 'user name',
                'value'     => old('username') ?? $thisAdmin->username,
                'required'  => true,
                'minlength' => 6,
                'maxlength' => 200,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $thisAdmin->name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'label',
                'label'     => 'label (displayed in url)',
                'value'     => old('label') ??  $thisAdmin->label,
                'minlength' => 6,
                'maxlength' => 200,
                'required'  => true,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'salutation',
                'value'   => old('salutation') ?? $thisAdmin->salutation,
                'list'    => new Admin()->salutationListOptions(true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('role') ?? $thisAdmin->title,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'role',
                'value'     => old('role') ?? $thisAdmin->role,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'employer',
                'value'     => old('employer') ?? $thisAdmin->employer,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'employment_status_id',
                'label'   => 'employment status',
                'value'   => old('employment_status_id') ?? $thisAdmin->employment_status_id,
                'list'    => new EmploymentStatus()->listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? $thisAdmin->street,
                'street2'    => old('street2') ?? $thisAdmin->street2,
                'city'       => old('city') ?? $thisAdmin->city,
                'state_id'   => old('state_id') ?? $thisAdmin->state_id,
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $thisAdmin->zip,
                'country_id' => old('country_id') ?? $thisAdmin->country_id,
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $thisAdmin->latitude,
                'longitude' => old('longitude') ?? $thisAdmin->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'tel',
                'name'      => 'phone',
                'value'     => old('phone') ?? $thisAdmin->phone,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'email',
                'name'      => 'email',
                'value'     => old('email') ?? $thisAdmin->email,
                'required'  => true,
                'disabled'  => true,
                'maxlength' => 255,
                'style'     => 'text-transform: lowercase',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'birthday',
                'value'   => old('birthday') ?? $thisAdmin->birthday,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $thisAdmin->link,
                'name' => old('link_name') ?? $thisAdmin->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'bio',
                'id'      => 'inputEditor',
                'value'   => old('bio') ?? $thisAdmin->bio,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $thisAdmin->description,
                'message' => $message ?? '',
            ])

            <?php
            /* --------------------------------------------- */
            /* Note: images are uploaded from the show page. */
            /* --------------------------------------------- */
            ?>
            @include('admin.components.form-image-horizontal', [
                'src'        => old('image') ?? $thisAdmin->image,
                'credit'     => old('image_credit') ?? $thisAdmin->image_credit,
                'source'     => old('image_source') ?? $thisAdmin->image_source,
                'message'    => $message ?? '',
                'uploadable' => false,
            ])

            @include('admin.components.form-image-horizontal', [
                'name'       => 'thumbnail',
                'src'        => old('thumbnail') ?? $thisAdmin->thumbnail,
                'credit'     => false,
                'source'     => false,
                'maxlength'  => 500,
                'message'    => $message ?? '',
                'uploadable' => false,
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $thisAdmin->is_public,
                'is_readonly' => old('is_readonly') ?? $thisAdmin->is_readonly,
                'is_root'     => old('is_root')     ?? $thisAdmin->is_root,
                'is_disabled' => old('is_disabled') ?? $thisAdmin->is_disabled,
                'is_demo'     => old('is_demo')     ?? $thisAdmin->is_demo,
                'sequence'    => old('sequence')    ?? $thisAdmin->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'requires_relogin',
                'label'           => 'requires re-login',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('requires_relogin') ?? $thisAdmin->requires_relogin,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.system.system.admin.index')
            ])

        </form>

    </div>

@endsection
