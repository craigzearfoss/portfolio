@php
    use App\Models\System\Country;
    use App\Models\System\Owner;
    use App\Models\System\State;

    $title    = $pageTitle ?? (!empty($title) ? $title : 'Contact: ' . $contact->name);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',       'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,   'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Contacts',     'href' => route('admin.career.contact.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $contact->name, 'href' => route('admin.career.contact.show', [$contact, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index') ];
        $breadcrumbs[] = [ 'name' => 'Contacts',     'href' => route('admin.career.contact.index') ];
        $breadcrumbs[] = [ 'name' => $contact->name, 'href' => route('admin.career.contact.show', $contact) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.contact.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $title,
    'subtitle'      => $subtitle,
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'menuService'   => $menuService,
    'admin'         => $admin,
    'user'          => $user,
    'owner'         => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.contact.update', array_merge([$contact], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.contact.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $contact->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $contact->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $contact->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $contact->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'salutation',
                'value'   => old('salutation') ?? $contact->salutation,
                'list'    => new Admin()->salutationListOptions(true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('role') ?? $contact->title,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? $contact->street,
                'street2'    => old('street2') ?? $contact->street2,
                'city'       => old('city') ?? $contact->city,
                'state_id'   => old('state_id') ?? $contact->state_id,
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $contact->zip,
                'country_id' => old('country_id') ?? $contact->country_id,
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $contact->latitude,
                'longitude' => old('longitude') ?? $contact->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone' => old('phone') ?? $contact->phone,
                'label' => old('phone_label') ?? $contact->phone_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone'   => old('alt_phone') ?? $contact->alt_phone,
                'label'   => old('alt_phone_label') ?? $contact->alt_phone_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('email') ?? $contact->email,
                'label'   => old('email_label') ?? $contact->email_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('alt_email') ?? $contact->alt_email,
                'label'   => old('alt_email_table') ?? $contact->alt_email_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'birthday',
                'value'   => old('birthday') ?? $contact->birthday,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $contact->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $contact->link,
                'name' => old('link_name') ?? $contact->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $contact->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $contact->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $contact->image,
                'credit'  => old('image_credit') ?? $contact->image_credit,
                'source'  => old('image_source') ?? $contact->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $contact->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? $contact->public,
                'readonly'    => old('readonly') ?? $contact->readonly,
                'root'        => old('root')     ?? $contact->root,
                'disabled'    => old('disabled') ?? $contact->disabled,
                'demo'        => old('demo')     ?? $contact->demo,
                'sequence'    => old('sequence') ?? $contact->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.contact.index')
            ])

        </form>

    </div>

@endsection
