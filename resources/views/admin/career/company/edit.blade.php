@php
    use App\Models\System\Country;
    use App\Models\System\Owner;
    use App\Models\System\State;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',       'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,   'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Companies',    'href' => route('admin.career.company.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $company->name, 'href' => route('admin.career.company.show', [$company, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index') ];
        $breadcrumbs[] = [ 'name' => 'Companies',    'href' => route('admin.career.company.index') ];
        $breadcrumbs[] = [ 'name' => $company->name, 'href' => route('admin.career.company.show', $company) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.company.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($title) ? $title : 'Company: ' . $company->name),
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

        <form action="{{ route('admin.career.company.update', array_merge([$company], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.company.index')
            ])

            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $company->owner_id
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $company->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $company->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $company->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $company->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'industry_id',
                'label'    => 'industry',
                'value'    => old('industry_id') ?? $company->industry_id,
                'required' => true,
                'list'     => \App\Models\Career\Industry::listOptions([], 'id', 'name', true, true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? $company->street,
                'street2'    => old('street2') ?? $company->street2,
                'city'       => old('city') ?? $company->city,
                'state_id'   => old('state_id') ?? $company->state_id,
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $company->zip,
                'country_id' => old('country_id') ?? $company->country_id,
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $company->latitude,
                'longitude' => old('longitude') ?? $company->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone' => old('phone') ?? $company->phone,
                'label' => old('phone_label') ?? $company->phone_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone'   => old('alt_phone') ?? $company->alt_phone,
                'label'   => old('alt_phone_label') ?? $company->alt_phone_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('email') ?? $company->email,
                'label'   => old('email_label') ?? $company->email_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('alt_email') ?? $company->alt_email,
                'label'   => old('alt_email_table') ?? $company->alt_email_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $company->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $company->link,
                'name' => old('link_name') ?? $company->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $company->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $company->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $company->image,
                'credit'  => old('image_credit') ?? $company->image_credit,
                'source'  => old('image_source') ?? $company->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $company->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'logo',
                'src'       => old('logo') ?? $company->logo,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'logo_small',
                'src'       => old('logo_small') ?? $company->logo_small,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $company->public,
                'readonly'    => old('readonly') ?? $company->readonly,
                'root'        => old('root')     ?? $company->root,
                'disabled'    => old('disabled') ?? $company->disabled,
                'demo'        => old('demo')     ?? $company->demo,
                'sequence'    => old('sequence') ?? $company->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.company.index')
            ])

        </form>

    </div>

@endsection
