@extends('admin.layouts.default', [
    'title' => !empty($title) ? $title : 'Application: ' . $application->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',             'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',           'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',     'href' => route('admin.career.application.index') ],
        [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
        [ 'name' => 'Edit' ],
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

        <form action="{{ route('admin.career.application.update', $application) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.application.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $application->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $application->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $application->owner_id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'     => 'company_id',
                'label'    => 'company',
                'value'    => old('company_id') ?? $application->company_id,
                'required' => true,
                'list'     => \App\Models\Career\Company::listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'role',
                'value'       => old('role') ?? $application->role,
                'required'    => true,
                'maxlength'   => 255,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'        => 'resume_id',
                'label'       => 'resume',
                'value'       => old('resume_id') ?? $application->resume_id,
                'list'        => \App\Models\Career\Resume::listOptions([], 'id', 'name', true),
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'rating',
                'value'       => old('rating') ?? $application->rating,
                'placeholder' => '1, 2, 3, or 4',
                'min'         => 1,
                'max'         => 4,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'active',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('active') ?? $application->active,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'post_date',
                'label'   => 'post date',
                'value'   => old('post_date') ?? $application->post_date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'apply_date',
                'label'   => 'apply date',
                'value'   => old('apply_date') ?? $application->apply_date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'close_date',
                'label'   => 'close date',
                'value'   => old('close_date') ?? $application->close_date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'number',
                'name'    => 'compensation_min',
                'label'   => 'min compensation ($)',
                'value'   => old('compensation_min') ?? $application->compensation_min,
                'min'     => 0,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'number',
                'name'    => 'compensation_max',
                'label'   => 'max compensation ($)',
                'value'   => old('compensation_max') ?? $application->compensation_max,
                'min'     => 0,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'compensation_unit_id',
                'label'   => 'compensation unit',
                'value'   => old('compensation_unit') ?? $application->compensation_unit_id,
                'list'    => \App\Models\Career\CompensationUnit::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'job_duration_type_id',
                'label'    => 'duration type',
                'value'    => old('job_duration_type_id') ?? $application->job_duration_type_id,
                'required' => true,
                'list'     => \App\Models\Career\JobDurationType::listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'job_employment_type_id',
                'label'    => 'employment type',
                'value'    => old('job_employment_type_id') ?? $application->job_employment_type_id,
                'required' => true,
                'list'     => \App\Models\Career\JobEmploymentType::listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'job_location_type_id',
                'label'    => 'location type',
                'value'    => old('job_location_type_id') ?? $application->job_location_type_id,
                'required' => true,
                'list'     => \App\Models\Career\JobLocationType::listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? $application->street,
                'street2'    => old('street2') ?? $application->street2,
                'city'       => old('city') ?? $application->city,
                'state_id'   => old('state_id') ?? $application->state_id,
                'states'     => \App\Models\System\State::listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $application->zip,
                'country_id' => old('country_id') ?? $application->country_id,
                'countries'  => \App\Models\System\Country::listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $application->latitude,
                'longitude' => old('longitude') ?? $application->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'bonus',
                'value'     => old('bonus') ?? $application->bonus,
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
                                'checked'         => old('w2') ?? $application->w2,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'relocation',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('relocation') ?? $application->relocation,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'benefits',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('benefits') ?? $application->benefits,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'vacation',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('vacation') ?? $application->vacation,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'health',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('health') ?? $application->health,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-select-horizontal', [
                'name'    => 'job_board_id',
                'label'   => 'job board',
                'value'   => old('job_board_id') ?? $application->job_board_id,
                'list'    => \App\Models\Career\JobBoard::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $application->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone' => old('phone') ?? $application->phone,
                'label' => old('phone_label') ?? $application->phone_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone'   => old('alt_phone') ?? $application->alt_phone,
                'label'   => old('alt_phone_label') ?? $application->alt_phone_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('email') ?? $application->email,
                'label'   => old('email_label') ?? $application->email_label,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('alt_email') ?? $application->alt_email,
                'label'   => old('alt_email_table') ?? $application->alt_email_label,
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $application->link,
                'name' => old('link_name') ?? $application->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $application->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $application->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $application->image,
                'credit'  => old('image_credit') ?? $application->image_credit,
                'source'  => old('image_source') ?? $application->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $application->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => $application->public,
                'readonly' => $application->readonly,
                'root'     => $application->root,
                'disabled' => $application->disabled,
                'demo'     => $application->demo,
                'sequence' => $application->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.application.index')
            ])

        </form>

    </div>

@endsection
