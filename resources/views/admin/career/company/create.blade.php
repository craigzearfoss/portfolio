@php
    use App\Models\System\Country;
    use App\Models\Career\Industry;
    use App\Models\System\Owner;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $company       = $company ?? null;

    $title    = $pageTitle ?? 'Add New Company';
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
    $breadcrumbs[] = [ 'name' => 'Companies',  'href' => route('admin.career.company.index') ];
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.company.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.company.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.company.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card has-background-white-ter p-4 m-2">

                    @if ($isRootAdmin)
                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'owner_id',
                            'label'    => 'owner',
                            'value'    => old('owner_id') ?? '',
                            'required' => true,
                            'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc ']),
                            'message'  => $message ?? '',
                        ])
                    @else
                        @include('admin.components.form-hidden', [
                            'name'  => 'owner_id',
                            'value' => $admin->id ?? null,
                        ])
                    @endif

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'name',
                        'value'     => old('name') ?? '',
                        'required'  => true,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                </div>
                <div class="floating-div card has-background-white-ter p-4 m-2">

                    @include('admin.components.form-select-horizontal', [
                        'name'    => 'industry_id',
                        'label'   => 'industry',
                        'value'   => old('industry_id') ?? 0,
                        'required'  => true,
                        'list'    => new Industry()->listOptions([], 'id', 'name', true, true),
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'        => 'number',
                        'name'        => 'founded',
                        'value'       => old('founded') ?? '',
                        'min'         => 0,
                        'message'     => $message ?? '',
                        'style'       => [ 'width: 6rem' ]
                    ])

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card has-background-white-ter p-4 m-2" style="width: 100%;">

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

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card has-background-white-ter p-4 m-2" style="width: 100%;">

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

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card has-background-white-ter p-4 m-2" style="width: 100%;">

                    @include('admin.components.form-link-horizontal', [
                        'link' => old('link') ?? '',
                        'name' => old('link_name') ?? '',
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-link-horizontal', [
                        'name'               => 'linkedin_url',
                        'label'              => 'linkedin url',
                        'link'               => old('linkedin_url') ?? '',
                        'include_name_field' => false,
                        'message'            => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? '',
                        'message' => $message ?? '',
                    ])

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card has-background-white-ter p-4 m-2" style="width: 100%;">

                    @include('admin.components.form-input-horizontal', [
                        'name'        => 'disclaimer',
                        'value'       => old('disclaimer') ?? '',
                        'maxlength'   => 500,
                        'message'     => $message ?? '',
                    ])

                    @include('admin.components.form-file-upload-horizontal', [
                        'name'      => 'logo',
                        'src'       => old('logo') ?? '',
                        'maxlength' => 500,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-file-upload-horizontal', [
                        'name'      => 'logo_small',
                        'src'       => old('logo_small') ?? '',
                        'maxlength' => 500,
                        'message'   => $message ?? '',
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

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div has-text-right m-2" style="width: 100%;">

                    @include('admin.components.form-button-submit', [
                        'label'      => 'Save Company',
                        'cancel_url' => referer('admin.career.company.index')
                    ])

                </div>

            </div>

        </form>

    </div>

@endsection
