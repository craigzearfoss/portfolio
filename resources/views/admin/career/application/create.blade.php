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
                'value'    => old('company_id') ?? '',
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
                'value'   => old('job_board_id') ?? 1,
                'list'    => \App\Models\Career\JobBoard::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'resume_id',
                'label'   => 'resume',
                'value'   => old('resume_id') ?? '',
                'list'    => \App\Models\Career\Resume::listOptions([], 'id', 'name', true),
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
                'name'    => 'compensation_unit',
                'label'   => 'compensation unit',
                'value'   => old('compensation_unit') ?? '',
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

            @include('admin.components.form-input-horizontal', [
                'name'      => 'street',
                'value'     => old('street') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'street2',
                'value'     => old('street2') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'city',
                'value'     => old('city') ?? '',
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'state_id',
                'value'   => old('state_id') ?? '',
                'list'    => \App\Models\System\State::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'zip',
                'value'     => old('zip') ?? '',
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'country_id',
                'label'   => 'country',
                'value'   => old('country_id') ?? '',
                'list'    => \App\Models\System\Country::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'latitude',
                'value'     => old('latitude') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'longitude',
                'value'     => old('longitude') ?? '',
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
                    <div class="field">

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

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone',
                'value'     => old('phone') ?? '',
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'phone_label',
                'label'     => 'phone label',
                'value'     => old('phone_label') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_phone',
                'label'     => 'alt phone',
                'value'     => old('alt_phone') ?? '',
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_phone_label',
                'label'     => 'alt phone label',
                'value'     => old('alt_phone_label') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'email',
                'value'     => old('email') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'email_label',
                'label'     => 'email label',
                'value'     => old('email_label') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_email',
                'label'     => 'alt email',
                'value'     => old('alt_email') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'alt_email_label',
                'label'     => 'alt email label',
                'value'     => old('alt_email_label') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link_name') ?? '',
                'maxlength' => 255,
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

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'image',
                'value'     => old('image') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_credit',
                'label'     => 'image credit',
                'value'     => old('image_credit') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'image_source',
                'label'     => 'image source',
                'value'     => old('image_source') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? 0,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'public',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('public') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'readonly',
                                'label'           => 'read-only',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('readonly') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @if(isRootAdmin())
                                @include('admin.components.form-checkbox', [
                                    'name'            => 'root',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('root') ?? 0,
                                    'disabled'        => 0,
                                    'message'         => $message ?? '',
                                ])
                            @endif

                            @include('admin.components.form-checkbox', [
                                'name'            => 'disabled',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('disabled') ?? 0,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Application',
                'cancel_url' => referer('admin.career.application.index')
            ])

        </form>

    </div>

@endsection
