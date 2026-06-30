@php
    use App\Models\Career\Company;
    use App\Models\Career\CompensationUnit;
    use App\Models\Career\JobBoard;
    use App\Models\Career\JobDurationType;
    use App\Models\Career\JobEmploymentType;
    use App\Models\Career\JobLocationType;
    use App\Models\System\Country;
    use App\Models\System\Owner;
    use App\Models\System\State;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $application = $application ?? null;

    $ownerModel = new Owner();

    $title    = $pageTitle ?? 'Add New Application';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                      'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',   'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications', 'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.application.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    @if (empty($companyId))

        <div class="edit-container card form-container p-4" style="max-width: 25rem;">

            <div class="content fa-width-auto has-text-centered">

                <form id="selectCompanyForm" action="{{ route('admin.career.application.create', request()->all()) }}"
                      method="GET">

                    @if ($isRootAdmin)
                        @include('admin.components.form-select', [
                            'name'     => 'owner_id',
                            'label'    => 'owner',
                            'value'    => old('owner_id') ?? request()->input('owner_id'),
                            'required' => true,
                            'list'     => $ownerModel->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                            'message'  => $message ?? '',
                        ])
                        <hr>
                    @endif

                    @include('admin.components.form-select', [
                        'name'     => 'company_id',
                        'label'    => 'Select a company',
                        'value'    => old('company_id') ?? '',
                        'required' => true,
                        'list'     => new Company()->listOptions([], 'id', 'name', true),
                        'onchange' => "document.getElementById('selectCompanyForm').submit();",
                        'message'  => $message ?? '',
                    ])

                    @include('admin.components.form-hidden', [
                        'name'     => 'resume_id',
                        'value'    => old('resume_id') ?? $resumeId ?? '',
                    ])

                    @include('admin.components.form-hidden', [
                        'name'     => 'cover_letter_id',
                        'value'    => old('cover_letter_id') ?? $coverLetterId ?? '',
                    ])

                </form>

                <h4 class="subtitle has-text-centered pt-4">or</h4>

                <a href="{{ route('admin.career.company.create', array_merge(['new_application' => 1], request()->all())) }}"
                   class="button is-primary my-0">
                    Add a New Company
                </a>

            </div>

        </div>

    @else

        <div class="edit-container card form-container p-4">

            <form action="{{ route('admin.career.application.store') }}"
                  class="admin-form"
                  method="POST"
            >
                @csrf

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => referer('admin.career.application.index')
                ])

                <div class="floating-div-container">

                     <div class="floating-div card admin-form-card mr-2" style="max-width: 51rem;">

                        @if ($isRootAdmin)
                            @include('admin.components.form-select-horizontal', [
                                'name'     => 'owner_id',
                                'label'    => 'owner',
                                'value'    => old('owner_id') ?? null,
                                'required' => true,
                                'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                                'message'  => $message ?? '',
                                'class'    => [ 'select-owner' ]
                            ])
                        @else
                            @include('admin.components.form-hidden', [
                                'name'  => 'owner_id',
                                'value' => $admin->id ?? null
                            ])
                        @endif

                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'company_id',
                            'label'    => 'company',
                            'value'    => old('company_id') ?? request()->input('company_id'),
                            'required' => true,
                            'list'     => new Company()->listOptions([], 'id', 'name', true),
                            'message'  => $message ?? '',
                            'class'    => [ 'select-company' ]
                        ])


                        <div class="field is-horizontal">
                            <div class="field-label">
                                <label for="inputRole" class="label label-required">
                                    role
                                </label>
                            </div>
                            <div class="field-body">
                                <div class="field mb-0">
                                    @include('admin.components.input', [
                                        'name'        => 'role',
                                        'value'       => old('role') ?? '',
                                        'required'  => true,
                                        'maxlength'   => 255,
                                        'message'     => $message ?? '',
                                    ])
                                </div>
                                <div class="field mb-0">
                                    @include('admin.components.input', [
                                        'name'        => 'reference_id',
                                        'value'       => old('reference_id') ?? '',
                                        'maxlength'   => 100,
                                        'placeholder' => 'reference id',
                                        'message'     => $message ?? '',
                                        'style'       => [ 'width: 10rem' ],
                                    ])
                                </div>
                            </div>
                        </div>

                        @include('admin.components.form-job-boards-horizontal', [
                            'job_board_id'  => old('job_board_id') ?? $application->job_board_id ?? null,
                            'job_board_id2' => old('job_board_id2') ?? $application->job_board_id2 ?? null,
                            'message'       => $message ?? '',
                        ])

                        <?php /*
                        @include('admin.components.form-text-horizontal', [
                            'name'       => 'cover letter',
                            'value'      => '<ul><li>' . $coverLetterFilepathLabel . '</li></ul>',
                            'message'    => $message ?? '',
                            'text_title' => $application->coverLetter['filepath']
                        ])

                        @include('admin.components.form-select-horizontal', [
                            'name'        => 'resume_id',
                            'label'       => 'resume',
                            'value'       => old('resume_id') ?? $application->resume_id,
                            'list'        => new Resume()->listOptions([ 'active' => 1 ], 'id', 'name', true),
                            'message'     => $message ?? '',
                        ])

                        @php
                            $resumeLinks = [];
                            if (!empty($application->resume['pdf_filepath'])) {
                                 $resumeLinks[] = '<li><strong>PDF file</strong>: <span title="' . $application->resume['pdf_filepath'] . '">' . $pdfResumeFilepathLabel . '</span></li>';
                            }
                            if (!empty($application->resume['doc_filepath'])) {
                                $resumeLinks[] = '<li><strong>MS Word file</strong>: <span title="' . $application->resume['doc_filepath'] . '">' . $docResumeFilepathLabel . '</span></li>';
                            }
                        @endphp

                        @include('admin.components.form-text-horizontal', [
                            'name'    => 'resume(s)',
                            'label'   => 'resume',
                            'value'   =>  !empty($resumeLinks)
                                              ? '<ul>' . implode('', $resumeLinks) . '</ul>'
                                              : '<ul><li><i>(None)</i></li></ul>',
                            'message' => $message ?? '',
                        ])
                        */ ?>

                    </div>
                    <div class="floating-div card admin-form-card" style="width: 21rem;">

                        @include('admin.components.form-input-horizontal', [
                            'type'    => 'date',
                            'name'    => 'post_date',
                            'label'   => 'post date',
                            'value'   => old('post_date') ?? null,
                            'message' => $message ?? '',
                        ])

                        @include('admin.components.form-input-horizontal', [
                            'type'    => 'date',
                            'name'    => 'apply_date',
                            'label'   => 'apply date',
                           'value'   => old('apply_date') ?? null,
                           'message' => $message ?? '',
                        ])

                        @include('admin.components.form-input-horizontal', [
                            'type'    => 'date',
                            'name'    => 'close_date',
                            'label'   => 'close date',
                            'value'   => old('close_date') ?? null,
                            'message' => $message ?? '',
                        ])

                    </div>
                    <div class="floating-div card admin-form-card mr-2" style="width: 36rem;">

                        @include('admin.components.form-checkbox-horizontal', [
                            'name'            => 'active',
                            'value'           => 1,
                            'unchecked_value' => 0,
                            'checked'         => old('active') ?? 1,
                            'message'         => $message ?? '',
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

                        @include('admin.components.form-job-duration-horizontal', [
                            'job_duration_type_id' => old('job_duration_type_id') ?? null,
                            'job_duration_length'  => old('job_duration_length') ?? null,
                            'job_duration_unit_id' => old('job_duration_unit_id') ?? null,
                        ])

                        <?php /*
                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'job_duration_type_id',
                            'label'    => 'duration type',
                            'value'    => old('job_duration_type_id') ?? null,
                            'required' => true,
                            'list'     => new JobDurationType()->listOptions([], 'id', 'name', true),
                            'message'  => $message ?? '',
                        ])

                        @include('admin.components.form-input-horizontal', [
                            'type'    => 'number',
                            'name'    => 'job_duration_length',
                            'label'   => 'duration length',
                            'value'   => old('job_duration_length') ?? null,
                            'min'     => 0,
                            'style'   => [ 'width: 5rem;' ],
                            'message' => $message ?? '',
                        ])

                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'job_duration_unit_id',
                            'label'    => 'duration unit',
                            'value'    => old('job_duration_unit_id') ?? null,
                            'list'     => new JobDurationUnit()->listOptions([], 'id', 'name', true),
                            'message'  => $message ?? '',
                        ])
                        */ ?>

                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'job_employment_type_id',
                            'label'    => 'employment',
                            'value'    => old('job_employment_type_id') ?? null,
                            'required' => true,
                            'list'     => new JobEmploymentType()->listOptions([], 'id', 'name', true),
                            'message'  => $message ?? '',
                            'style'    => [ 'width: 10rem' ],
                        ])

                        @include('admin.components.form-select-horizontal', [
                            'name'     => 'job_location_type_id',
                            'label'    => 'location',
                            'value'    => old('job_location_type_id') ?? null,
                            'required' => true,
                            'list'     => new JobLocationType()->listOptions([], 'id', 'name', true),
                            'message'  => $message ?? '',
                            'style'    => [ 'width: 7rem' ],
                        ])

                    </div>
                    <div class="floating-div card admin-form-card mr-2" style="width: 26rem;">

                        @include('admin.components.form-input-horizontal', [
                            'type'    => 'number',
                            'name'    => 'compensation_min',
                            'label'   => 'min comp. ($)',
                            'value'   => old('compensation_min') ?? null,
                            'min'     => 0,
                            'message' => $message ?? '',
                        ])

                        @include('admin.components.form-input-horizontal', [
                            'type'    => 'number',
                            'name'    => 'compensation_max',
                            'label'   => 'max comp. ($)',
                            'value'   => old('compensation_max') ?? null,
                            'min'     => 0,
                            'message' => $message ?? '',
                        ])

                        @include('admin.components.form-select-horizontal', [
                            'name'    => 'compensation_unit_id',
                            'label'   => 'comp. unit',
                            'value'   => old('compensation_unit') ?? null,
                            'list'    => new CompensationUnit()->listOptions([], 'id', 'name', true),
                            'message' => $message ?? '',
                            'style'   => [ 'width: 6rem' ],
                        ])

                        @include('admin.components.form-input-horizontal', [
                            'name'      => 'bonus',
                            'value'     => old('bonus') ?? null,
                            'maxlength' => 255,
                           'message'   => $message ?? '',
                        ])

                    </div>

                    <div class="floating-div card admin-form-card" style="width: 9rem;">

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

                        @include('admin.components.form-checkbox', [
                            'name'            => 'fouroonek',
                            'label'           => '401(k)',
                            'value'           => 1,
                            'unchecked_value' => 0,
                            'checked'         => old('fouroonek') ?? 0,
                            'message'         => $message ?? '',
                        ])

                    </div>
                    <div class="floating-div card admin-form-card">

                        @include('admin.components.form-location-horizontal', [
                            'street'     => old('street') ?? '',
                            'street2'    => old('street2') ?? '',
                            'city'       => old('city') ?? '',
                            'state_id'   => old('state_id') ?? null,
                            'states'     => new State()->listOptions([], 'id', 'name', true),
                            'zip'        => old('zip') ?? '',
                            'country_id' => old('country_id') ?? null,
                            'countries'  => new Country()->listOptions([], 'id', 'name', true),
                            'message'    => $message ?? '',
                        ])

                        @include('admin.components.form-coordinates-horizontal', [
                            'latitude'  => old('latitude') ?? null,
                            'longitude' => old('longitude') ?? null,
                            'message'   => $message ?? '',
                        ])

                </div>
                <div class="floating-div card admin-form-card">

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
                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'name'      => 'link',
                        'label'     => 'link',
                        'link'      => old('link') ?? '',
                        'link_name' => old('link_name') ?? '',
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-link-horizontal', [
                        'name'      => 'link2',
                        'label'     => 'link 2',
                        'link'      => old('link2') ?? '',
                        'link_name' => old('link2_name') ?? '',
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? '',
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-description' ],
                    ])
                    <input type="hidden" id="inputDescriptionChanged" name="description_changed" value="0">

                </div>
                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-textarea-horizontal', [
                        'name'      => 'disclaimer',
                        'value'     => old('disclaimer') ?? '',
                        'maxlength' => 500,
                        'cols'      => 30,
                        'rows'      => 3,
                        'message'   => $message ?? '',
                        'class'     => [ 'textarea-disclaimer' ],
                    ])

                    @include('admin.components.show-row-images', [
                        'resource' => $application,
                        'upload'   => false,
                        'download' => true,
                        'external' => true,
                        'editPage' => true,
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'notes',
                        'value'   => old('notes') ?? '',
                        'message' => $message ?? '',
                        'class'   => 'textarea-notes'
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

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Application',
                'cancel_url' => referer('admin.career.application.index')
            ])

            </form>

        </div>

    @endif;

@endsection
