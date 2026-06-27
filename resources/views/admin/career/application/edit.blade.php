@php
    use App\Models\Career\Company;
    use App\Models\Career\CompensationUnit;
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

    $title    = 'Edit ' . getResourcePageTitle($application);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                 'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                      'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                              'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',                                  'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications',                            'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($application, false), 'href' => route('admin.career.application.show', $application) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.application.index') ])->render(),
    ];

    // get label for cover letter filepath
    if ($parts = explode(DIRECTORY_SEPARATOR, $application->coverLetter['filepath'])) {
        $coverLetterFilepathLabel = $parts[count($parts) - 1];
    } else {
        $coverLetterFilepathLabel = '(None)';
    }

    // get label for doc resume filepath
    if ($parts = explode(DIRECTORY_SEPARATOR, $application->resume['doc_filepath'])) {
        $docResumeFilepathLabel = $parts[count($parts) - 1];
    } else {
        $docResumeFilepathLabel = '(None)';
    }

    // get label for pdf resume filepath
    if ($parts = explode(DIRECTORY_SEPARATOR, $application->resume['pdf_filepath'])) {
        $pdfResumeFilepathLabel = $parts[count($parts) - 1];
    } else {
        $pdfResumeFilepathLabel = '(None)';
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.application.update', array_merge([$application], request()->all())) }}"
              class="admin-form"
              method="POST"
        >
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.application.index')
            ])

            <div class="floating-div-container">

                <div class="floating-div card admin-form-card mr-2" style="max-width: 51rem;">

                    @if ($isRootAdmin)
                        @include('admin.components.favorites-box-form-input', [
                            'name'  => 'favorite_count',
                            'label' => 'favorites',
                            'value' => old('favorite_count') ?? $application->favorite_count,
                        ])
                    @endif

                    @include('admin.components.form-text-horizontal', [
                        'name'  => 'id',
                        'value' => $application->id,
                        'hide'  => !$isRootAdmin,
                    ])

                        @if ($isRootAdmin)
                            @include('admin.components.form-select-horizontal', [
                                'name'     => 'owner_id',
                                'label'    => 'owner',
                                'value'    => old('owner_id') ?? $application->owner_id,
                                'required' => true,
                                'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                                'message'  => $message ?? '',
                                'class'    => [ 'select-owner' ]
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
                        'list'     => new Company()->listOptions([], 'id', 'name', true),
                        'message'  => $message ?? '',
                    ])

                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label for="inputRole" class="label label-required" title="{{ $application->role ?? '' }}">
                                role
                            </label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                @include('admin.components.input', [
                                    'name'        => 'role',
                                    'value'       => old('role') ?? $application->role,
                                    'required'  => true,
                                    'maxlength'   => 255,
                                    'message'     => $message ?? '',
                                ])
                            </div>
                            <div class="field">
                                @include('admin.components.input', [
                                    'name'        => 'reference_id',
                                    'value'       => old('reference_id') ?? $application->reference_id,
                                    'maxlength'   => 100,
                                    'placeholder' => 'reference id',
                                    'style'       => [ 'width: 10rem' ],
                                    'message'     => $message ?? '',
                                ])
                            </div>
                        </div>
                    </div>

                    @include('admin.components.form-job-boards-horizontal', [
                        'job_board_id'  => old('job_board_id') ?? $application->job_board_id ?? null,
                        'job_board_id2' => old('job_board_id2') ?? $application->job_board_id2 ?? null,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-text-horizontal', [
                        'name'       => 'cover letter',
                        'value'      => '<ul><li>' . $coverLetterFilepathLabel . '</li></ul>',
                        'message'    => $message ?? '',
                        'text_title' => $application->coverLetter['filepath']
                    ])

                    <?php /*
                    @include('admin.components.form-select-horizontal', [
                        'name'        => 'resume_id',
                        'label'       => 'resume',
                        'value'       => old('resume_id') ?? $application->resume_id,
                        'list'        => new Resume()->listOptions([ 'active' => 1 ], 'id', 'name', true),
                        'message'     => $message ?? '',
                    ])
                    */ ?>


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
                        'name'        => 'resume(s)',
                        'label'       => 'resume',
                        'value'       =>  !empty($resumeLinks)
                                                ? '<ul>' . implode('', $resumeLinks) . '</ul>'
                                                : '<ul><li><i>(None)</i></li></ul>',
                        'message'     => $message ?? '',
                    ])

                </div>
                <div class="floating-div card admin-form-card" style="width: 21rem;">

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

                </div>
                <div class="floating-div card admin-form-card mr-2" style="width: 36rem;">

                    @include('admin.components.form-checkbox-horizontal', [
                        'name'            => 'active',
                        'value'           => 1,
                        'unchecked_value' => 0,
                        'checked'         => old('active') ?? $application->active,
                        'message'         => $message ?? '',
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

                    @include('admin.components.form-job-duration-horizontal', [
                        'job_duration_type_id' => $application->job_duration_type_id,
                        'job_duration_length'  => $application->job_duration_length,
                        'job_duration_unit_id' => $application->job_duration_unit_id,
                    ])

                    <?php /*
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'job_duration_type_id',
                        'label'    => 'duration type',
                        'value'    => old('job_duration_type_id') ?? $application->job_duration_type_id,
                        'required' => true,
                        'list'     => new JobDurationType()->listOptions([], 'id', 'name', true),
                        'message'  => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'    => 'number',
                        'name'    => 'job_duration_length',
                        'label'   => 'duration length',
                        'value'   => old('job_duration_length') ?? $application->job_duration_length,
                        'min'     => 0,
                        'style'   => [ 'width: 5rem;' ],
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'job_duration_unit_id',
                        'label'    => 'duration unit',
                        'value'    => old('job_duration_unit_id') ?? $application->job_duration_unit_id,
                        'list'     => new JobDurationUnit()->listOptions([], 'id', 'name', true),
                        'message'  => $message ?? '',
                    ])
                    */ ?>

                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'job_employment_type_id',
                        'label'    => 'employment',
                        'value'    => old('job_employment_type_id') ?? $application->job_employment_type_id,
                        'required' => true,
                        'list'     => new JobEmploymentType()->listOptions([], 'id', 'name', true),
                        'message'  => $message ?? '',
                        'style'    => [ 'width: 10rem' ],
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'job_location_type_id',
                        'label'    => 'location',
                        'value'    => old('job_location_type_id') ?? $application->job_location_type_id,
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
                        'value'   => old('compensation_min') ?? $application->compensation_min,
                        'min'     => 0,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'type'    => 'number',
                        'name'    => 'compensation_max',
                        'label'   => 'max comp. ($)',
                        'value'   => old('compensation_max') ?? $application->compensation_max,
                        'min'     => 0,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-select-horizontal', [
                        'name'    => 'compensation_unit_id',
                        'label'   => 'comp. unit',
                        'value'   => old('compensation_unit') ?? $application->compensation_unit_id,
                        'list'    => new CompensationUnit()->listOptions([], 'id', 'name', true),
                        'message' => $message ?? '',
                        'style'   => [ 'width: 6rem' ],
                    ])

                    @include('admin.components.form-input-horizontal', [
                        'name'      => 'bonus',
                        'value'     => old('bonus') ?? $application->bonus,
                        'maxlength' => 255,
                        'message'   => $message ?? '',
                    ])

                </div>

                <div class="floating-div card admin-form-card" style="width: 9rem;">

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

                    @include('admin.components.form-checkbox', [
                        'name'            => 'fouroonek',
                        'label'           => '401(k)',
                        'value'           => 1,
                        'unchecked_value' => 0,
                        'checked'         => old('fouroonek') ?? $application->fouroonek,
                        'message'         => $message ?? '',
                    ])

                </div>
                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-location-horizontal', [
                        'street'     => old('street') ?? $application->street,
                        'street2'    => old('street2') ?? $application->street2,
                        'city'       => old('city') ?? $application->city,
                        'state_id'   => old('state_id') ?? $application->state_id,
                        'states'     => new State()->listOptions([], 'id', 'name', true),
                        'zip'        => old('zip') ?? $application->zip,
                        'country_id' => old('country_id') ?? $application->country_id,
                        'countries'  => new Country()->listOptions([], 'id', 'name', true),
                        'message'    => $message ?? '',
                    ])

                    @include('admin.components.form-coordinates-horizontal', [
                        'latitude'  => old('latitude') ?? $application->latitude,
                        'longitude' => old('longitude') ?? $application->longitude,
                        'message'   => $message ?? '',
                    ])

                </div>
                <div class="floating-div card admin-form-card">

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

                </div>
                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-link-horizontal', [
                        'name'      => 'link',
                        'label'     => 'link',
                        'link'      => old('link') ?? $application->link,
                        'link_name' => old('link_name') ?? $application->link_name,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-link-horizontal', [
                        'name'      => 'link2',
                        'label'     => 'link 2',
                        'link'      => old('link2') ?? $application->link2,
                        'link_name' => old('link2_name') ?? $application->link2_name,
                        'message'   => $message ?? '',
                    ])

                    @include('admin.components.form-textarea-horizontal', [
                        'name'    => 'description',
                        'id'      => 'inputEditor',
                        'value'   => old('description') ?? $application->description,
                        'message' => $message ?? '',
                        'class'   => [ 'textarea-description' ],
                    ])
                    <input type="hidden" id="inputDescriptionChanged" name="description_changed" value="0">

                </div>
                <div class="floating-div card admin-form-card">

                    @include('admin.components.form-textarea-horizontal', [
                        'name'      => 'disclaimer',
                        'value'     => old('disclaimer') ?? $application->disclaimer,
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
                        'value'   => old('notes') ?? $application->notes,
                        'message' => $message ?? '',
                    ])

                    @include('admin.components.form-visibility-horizontal', [
                        'is_public'   => old('is_public')   ?? $application->is_public,
                        'is_readonly' => old('is_readonly') ?? $application->is_readonly,
                        'is_root'     => old('is_root')     ?? $application->is_root,
                        'is_disabled' => old('is_disabled') ?? $application->is_disabled,
                        'is_demo'     => old('is_demo')     ?? $application->is_demo,
                        'sequence'    => old('sequence')    ?? $application->sequence,
                        'message'     => $message           ?? '',
                    ])

                </div>

            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.application.index')
            ])

        </form>

    </div>

@endsection
