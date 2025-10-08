@extends('admin.layouts.default', [
    'title' =>'Add New Job',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Jobs',            'href' => route('admin.portfolio.job.index') ],
        [ 'name' => 'Add' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.job.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.job.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job.index')
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
                    'required' => true,
                    'list'     => \App\Models\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'company',
                'value'     => old('company') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'role',
                'value'     => old('role') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? 1,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('name') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @php
                $startMonth = view('admin.components.form-select', [
                    'name'      => 'start_month',
                    'label'     => '',
                    'value'     => old('start_month') ?? '',
                    'list'      => months(true),
                    'message'   => $message ?? '',
                ]);
                $startYear = view('admin.components.form-input', [
                    'type'      => 'number',
                    'name'      => 'start_year',
                    'label'     => '',
                    'value'     => old('start_year') ?? '',
                    'min'       => 1980,
                    'max'       => 2050,
                    'message'   => $message ?? '',
                ]);
            @endphp

            @include('admin.components.form-text-horizontal', [
                'name'  => 'start',
                'value' => '<div style="display: flex; gap: 0.4em; margin-left: -0.5em; margin-top: -0.5em;">'
                            . '<div>'
                                . $startMonth
                            . '</div><div>'
                                . $startYear
                            . '</div></div>',
                'raw'   => true
            ])

            @php
                $endMonth = view('admin.components.form-select', [
                    'name'      => 'end_month',
                    'label'     => '',
                    'value'     => old('end_month') ?? '',
                    'list'      => months(true),
                    'message'   => $message ?? '',
                ]);
                $endYear = view('admin.components.form-input', [
                    'type'      => 'number',
                    'name'      => 'end_year',
                    'label'     => '',
                    'value'     => old('end_year') ?? '',
                    'min'       => 1980,
                    'max'       => 2050,
                    'message'   => $message ?? '',
                ]);
            @endphp

            @include('admin.components.form-text-horizontal', [
                'name'  => 'end',
                'value' => '<div style="display: flex; gap: 0.4em; margin-left: -0.5em; margin-top: -0.5em;">'
                            . '<div>'
                                . $endMonth
                            . '</div><div>'
                                . $endYear
                            . '</div></div>',
                'raw'   => true
            ])


            @include('admin.components.form-select-horizontal', [
                'name'     => 'job_employment_type_id',
                'label'    => 'employment type',
                'value'    => old('job_employment_type_id') ?? '',
                'required' => true,
                'list'     => \App\Models\Portfolio\JobEmploymentType::listOptions(
                                    [], 'id', 'name', true
                                ),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'job_location_type_id',
                'label'    => 'location type',
                'value'    => old('job_location_type_id') ?? '',
                'required' => true,
                'list'     => \App\Models\Portfolio\JobLocationType::listOptions(
                                    [], 'id', 'name', true
                                ),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
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
                'label'   => 'state',
                'value'   => old('state_id') ?? '',
                'list'    => \App\Models\State::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'zip',
                'value'     => old('city') ?? '',
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'country_id',
                'label'   => 'country',
                'value'   => old('country_id') ?? '',
                'list'    => \App\Models\Country::listOptions([], 'id', 'name', true),
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

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $reading->notes,
                'message' => $message ?? '',
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
                'label'      => 'Add Job',
                'cancel_url' => referer('admin.portfolio.job.index')
            ])

        </form>

    </div>

@endsection
