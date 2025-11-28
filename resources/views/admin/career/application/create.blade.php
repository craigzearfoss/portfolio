@extends('admin.layouts.default', [
    'title' => $title ?? 'Add New Application',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',    'href' => route('admin.career.application.index') ],
        [ 'name' => 'Add' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.application.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    @if(empty($companyId))

        <div class="edit-container card form-container p-4" style="max-width: 25rem;">

            <div class="content fa-width-auto has-text-centered">

                <form id="selectCompanyForm" action="{{ route('admin.career.application.create') }}" method="GET">

                    @if(isRootAdmin())
                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'owner_id',
                            'label'    => 'owner',
                            'value'    => old('owner_id') ?? '',
                            'required' => true,
                            'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                            'message'  => $message ?? '',
                        ])
                    @endif

                    @include('admin.components.form-select', [
                        'name'     => 'company_id',
                        'label'    => 'Select a company',
                        'value'    => old('company_id') ?? '',
                        'required' => true,
                        'list'     => \App\Models\Career\Company::listOptions([], 'id', 'name', true),
                        'onchange' => "document.getElementById('selectCompanyForm').submit();",
                        'message'  => $message ?? '',
                    ])

                </form>

                <h4 class="subtitle has-text-centered pt-4">or</h4>

                <a href="{{ route('admin.career.company.create', ['new_application' => 1]) }}" class="button is-primary my-0">
                    Add a New Company
                </a>

            </div>

        </div>

    @else

        <div class="edit-container card form-container p-4">

            <form action="{{ route('admin.career.application.store') }}" method="POST">
                @csrf

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('admin.career.application.index')
                ])

                @if(isRootAdmin())
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? '',
                        'required' => true,
                        'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                        'message'  => $message ?? '',
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => Auth::guard('admin')->user()->id
                    ])
                @endif

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'company_id',
                    'label'    => 'company',
                    'value'    => old('company_id') ?? $companyId,
                    'required' => true,
                    'list'     => \App\Models\Career\Company::listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'role',
                    'value'     => old('role') ?? '',
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'job_board_id',
                    'label'   => 'job board',
                    'value'   => old('job_board_id') ?? '',
                    'list'    => \App\Models\Career\JobBoard::listOptions([], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'number',
                    'name'        => 'rating',
                    'value'       => old('rating') ?? 1,
                    'placeholder' => '1, 2, 3, or 4',
                    'min'         => 1,
                    'max'         => 4,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'active',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('active') ?? 0,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'    => 'date',
                    'name'    => 'post_date',
                    'label'   => 'post date',
                    'value'   => old('post_date') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'    => 'date',
                    'name'    => 'apply_date',
                    'label'   => 'apply date',
                    'value'   => old('apply_date') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'    => 'date',
                    'name'    => 'close_date',
                    'label'   => 'close date',
                    'value'   => old('close_date') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'    => 'number',
                    'name'    => 'compensation_min',
                    'label'   => 'min compensation ($)',
                    'value'   => old('compensation_min') ?? '',
                    'min'     => 0,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'    => 'number',
                    'name'    => 'compensation_max',
                    'label'   => 'max compensation ($)',
                    'value'   => old('compensation_max') ?? '',
                    'min'     => 0,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'compensation_unit_id',
                    'label'   => 'compensation unit',
                    'value'   => old('compensation_unit_id') ?? '',
                    'list'    => \App\Models\Career\CompensationUnit::listOptions([], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'job_duration_type_id',
                    'label'   => 'duration type',
                    'value'   => old('job_duration_type_id') ?? '',
                    'required'  => true,
                    'list'    => \App\Models\Career\JobDurationType::listOptions([], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'job_employment_type_id',
                    'label'    => 'employment type',
                    'value'    => old('job_employment_type_id') ?? '',
                    'required' => true,
                    'list'     => \App\Models\Career\JobEmploymentType::listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'job_location_type_id',
                    'label'    => 'location type',
                    'value'    => old('job_location_type_id') ?? '',
                    'required' => true,
                    'list'     => \App\Models\Career\JobLocationType::listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-location-horizontal', [
                    'street'     => old('street') ?? '',
                    'street2'    => old('street2') ?? '',
                    'city'       => old('city') ?? '',
                    'state_id'   => old('state_id') ?? '',
                    'states'     => \App\Models\System\State::listOptions([], 'id', 'name', true),
                    'zip'        => old('zip') ?? '',
                    'country_id' => old('country_id') ?? '',
                    'countries'  => \App\Models\System\Country::listOptions([], 'id', 'name', true),
                    'message'    => $message ?? '',
                ])

                @include('admin.components.form-coordinates-horizontal', [
                    'latitude'  => old('latitude') ?? '',
                    'longitude' => old('longitude') ?? '',
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'bonus',
                    'value'     => old('bonus') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field" style="flex-grow: 0;">

                            <div class="checkbox-container card form-container p-4">

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'w2',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('w2') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'relocation',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('relocation') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'benefits',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('benefits') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'vacation',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('vacation') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'health',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('health') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

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

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? '',
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

                @include('admin.components.form-image-horizontal', [
                    'image'   => old('image') ?? '',
                    'credit'  => old('image_credit') ?? '',
                    'source'  => old('image_source') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-file-upload-horizontal', [
                    'name'      => 'thumbnail',
                    'value'     => old('thumbnail') ?? '',
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-settings-horizontal', [
                    'public'   => old('public') ?? '',
                    'readonly' => old('readonly') ?? '',
                    'root'     => old('root') ?? '',
                    'disabled' => old('disabled') ?? '',
                    'demo'     => old('demo') ?? '',
                    'sequence' => old('sequence') ?? '',
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-button-submit-horizontal', [
                    'label'      => 'Add Application',
                    'cancel_url' => referer('admin.career.application.index')
                ])

            </form>

        </div>

    @endif;

@endsection
