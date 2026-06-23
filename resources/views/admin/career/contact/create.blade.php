@php
    use App\Models\Career\Company;
    use App\Models\Career\Contact;
    use App\Models\Career\Recruiter;
    use App\Models\System\Country;
    use App\Models\System\Owner;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $contact       = $contact ?? null;

    $title    = $pageTitle ?? (!empty($recruiter_id) ? 'Add New Recruiting Contact' : 'Add New Contact');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Contacts',   'href' => route('admin.career.contact.index') ];
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.contact.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.contact.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.contact.index')
            ])

            @if ($isRootAdmin)
                @include('admin.components.favorites-box-form-input', [
                    'name'  => 'favorite_count',
                    'label' => 'favorites',
                    'value' => old('favorite_count') ?? 0,
                ])
            @endif

            @if ($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $admin->id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $admin->id ?? null,
                ])
            @endif

            @if (!empty($recruiter_id))
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'recruiter_id',
                    'label'    => 'recruiting firm',
                    'value'    => old('recruiter_id') ?? '',
                    'required' => true,
                    'list'     => new Recruiter()->listOptions([], 'id', 'name', true, false, [ 'name', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @endif;

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'salutation',
                'value'   => old('salutation') ?? '',
                'list'    => new Contact()->salutationListOptions(true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'role',
                'value'     => old('role') ?? '',
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'    => 'title',
                'value'   => old('title') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'company_id',
                'label'   => 'company',
                'value'   => old('company_id') ?? request()->query('company_id') ?? '',
                'list'    => new Company()->listOptions([], 'id', 'name', true, false, [ 'name', 'asc' ]),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? '',
                'street2'    => old('street2') ?? '',
                'city'       => old('city') ?? '',
                'state_id'   => old('state_id') ?? '',
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? '',
                'country_id' => old('country_id') ?? '',
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
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
                'label'   => old('alt_email_table') ?? '',
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'birthday',
                'value'   => old('birthday') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? '',
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? 0,
                'is_readonly' => old('is_readonly') ?? 0,
                'is_root'     => old('is_root')     ?? 0,
                'is_disabled' => old('is_disabled') ?? 0,
                'is_demo'     => old('is_demo')     ?? 0,
                'sequence'    => old('sequence')    ?? 0,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit', [
                'label'      => 'Save Contact',
                'cancel_url' => referer('admin.career.contact.index')
            ])

        </form>

    </div>

@endsection
