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

    $title    = 'Edit ' . getResourcePageTitle($company);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                             'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                  'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                          'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',                              'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Companies',                           'href' => route('admin.career.company.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($company, false), 'href' => route('admin.career.company.show', $company) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.company.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.company.update', array_merge([$company], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.company.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card mr-2" style="width: 36rem;">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $company->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $company->id,
                        'hide'  => !$isRootAdmin,
                    ])

                    @if ($isRootAdmin)
                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'owner_id',
                            'label'    => 'owner',
                            'value'    => old('owner_id') ?? $company->owner_id,
                            'required' => true,
                            'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                            'message'  => $message ?? '',
                            'class'    => [ 'select-owner' ]
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
                        'class'     => [ 'input-name' ],
                        'style'     => [ 'width: 26rem' ]
                    ])

                </div>
                <div class="floating-div card admin-form-card" style="width: 35rem;">

                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'industry_id',
                        'label'    => 'industry',
                        'value'    => old('industry_id') ?? $company->industry_id,
                        'required' => true,
                        'list'     => new Industry()->listOptions([], 'id', 'name', true, true),
                        'message'  => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'        => 'number',
                        'name'        => 'founded',
                        'value'       => old('founded') ?? $company->founded,
                        'min'         => 0,
                        'message'     => $message ?? '',
                        'style'       => [ 'width: 6rem' ]
                    ])

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

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

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

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

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'link'    => old('link') ?? $company->link,
                        'name'    => old('link_name') ?? $company->link_name,
                        'class'   => [ 'form-input-url' ],
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-link-horizontal', [
                        'name'               => 'linkedin_url',
                        'label'              => 'linkedin url',
                        'link'               => old('linkedin_url') ?? $company->linkedin_url,
                        'include_name_field' => false,
                        'class'              => [ 'form-input-url' ],
                        'message'            => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $company->description,
                        'class'   => [ 'form-textarea-description' ],
                        'message' => $message ?? '',
                    ])

                </div>

            </div>
            <div class="floating-div-container">

                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-textarea-horizontal', [
                        'name'      => 'disclaimer',
                        'value'     => old('disclaimer') ?? $company->disclaimer,
                        'maxlength' => 500,
                        'cols'      => 30,
                        'rows'      => 3,
                        'message'   => $message ?? '',
                        'class'     => [ 'textarea-disclaimer' ],
                    ])

                    @include('admin.components.show-row-images', [
                        'resource' => $company,
                        'upload'   => false,
                        'download' => true,
                        'external' => true,
                        'editPage' => true,
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'value'   => old('notes') ?? $company->notes,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $company->is_public,
                        'is_readonly' => old('is_readonly') ?? $company->is_readonly,
                        'is_root'     => old('is_root')     ?? $company->root,
                        'is_disabled' => old('is_disabled') ?? $company->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $company->is_demo,
                        'sequence'    => old('sequence')    ?? $company->sequence,
                        'message'     => $message           ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.company.index')
            ])

        </form>

    </div>

@endsection
