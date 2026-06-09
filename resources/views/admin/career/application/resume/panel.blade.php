@php
    use App\Models\Career\Resume;

    if (!$application = $application ?? null) {
        abort(500, 'No $application specified.');
    }

    $resumeModel = new Resume();

    $resumeId                  = $application->resume_id;
    $applicationResumeFilepath = $application->resume_filepath;
    $applicationResumeDate     = $application->resume_date;

    if (!empty($applicationResumeFilepath)) {
        $fileExtension = substr($applicationResumeFilepath, strrpos($applicationResumeFilepath, '.') + 1);
        $href = imageUrl($applicationResumeFilepath);
    } else {
        $fileExtension = null;
        $href = null;
    }

    $resume = !empty($resumeId)
        ? $resumeModel->find($resumeId)
        : null;

    $resumes = $resumeModel->searchQuery([ 'owner_id' => $application->owner_id ])->get();
    //dd($resumes);
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Resume
    </h3>

    <hr class="navbar-divider">

    <div class="has-text-centered" style="max-width: 80rem;">

        <div class="edit-container">

            <div class="field is-horizontal">
                <div class="field-label" style="min-width: 6rem;">
                    <strong></strong>
                </div>
                <div class="field-body">
                    <div class="card p-2 border-1">

                        <div class="mr-4" style="display: inline-block;">
                            @include('guest.components.form-checkbox', [
                                'id'              => 'active-resumes',
                                'name'            => 'active',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => 1,
                                'class'           => 'resume-filter-checkbox',
                                'attributes'      => [ 'filterType' => 'data-active' ],
                            ])
                        </div>
                        <div class="mr-4" style="display: inline-block;">
                            @include('guest.components.form-checkbox', [
                                'id'              => 'primary-resumes',
                                'name'            => 'primary',
                                'label'           => 'primary',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => 0,
                                'class'           => 'resume-filter-checkbox',
                                'attributes'      => [ 'filterType' => 'data-primary' ],
                            ])
                        </div>
                        <div style="display: inline-block;">
                            @include('guest.components.form-checkbox', [
                                'id'              => 'public-resumes',
                                'name'            => 'public',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => 0,
                                'class'           => 'resume-filter-checkbox',
                                'attributes'      => [ 'filterType' => 'data-public' ],
                            ])
                        </div>
                        <div style="display: inline-block;">
                            @include('guest.components.form-checkbox', [
                                'id'              => 'word-resumes',
                                'name'            => 'word',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => 1,
                                'class'           => 'resume-filter-checkbox',
                                'attributes'      => [ 'filterType' => 'data-word' ],
                            ])
                        </div>
                        <div style="display: inline-block;">
                            @include('guest.components.form-checkbox', [
                                'id'              => 'pdf-resumes',
                                'name'            => 'pdf',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => 1,
                                'class'           => 'resume-filter-checkbox',
                                'attributes'      => [ 'filterType' => 'data-pdf' ],
                            ])
                        </div>

                    </div>

                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label" style="min-width: 6rem;">
                    <strong>name</strong>
                </div>
                <div class="field-body">
                    <div class="field has-text-left">

                        <form name="frmAttachResumeFile"
                              action="{{ route('admin.career.application.resume.attach.store', $application) }}"
                              method="post"
                        >
                            @csrf

                            <select id="application-select-resume"
                                    name="application_resume"
                                    class="form-select"
                                    data-current-resume-id="{{ $resumeId }}"
                            >

                                <option value="" data-active="1"></option>

                                @foreach ($resumes as $resume)

                                    @foreach ([ 'pdf' => 'pdf_filepath', 'doc' => 'doc_filepath' ] as $fileType=>$column)

                                        @if (!empty($resume->{$column}))
                                            <option value         = "{{ $resume['id'] }}|{{ $fileType }}"
                                                    data-id       = "{{ $resume['id'] }}"
                                                    data-href     = "{{ imageUrl($resume->{$column}) }}"
                                                    data-active   = "{{ $resume['active'] ? '1' : '0' }}"
                                                    data-primary  = "{{ $resume['primary'] ? '1' : '0' }}"
                                                    data-public   = "{{ $resume['public'] ? '1' : '0' }}"
                                                    data-filetype = "{{ $fileType }}"
                                                    data-word     = "{{ ($fileType == 'word') ? '1' : '0' }}"
                                                    data-pdfd     = "{{ ($fileType == 'pdf') ? '1' : '0' }}"
                                                    data-current  = "{{ $resume['id'] == $resumeId ? '1' : '0' }}"
                                                    @if ($resume['active'])
                                                        style="color: rgb(0, 209, 178); font-weight: 700;"
                                                    @endif
                                                    @if ($resume['id'] == $resumeId)
                                                        selected
                                                    @endif
                                            >
                                                {{ $resume['name'] }} - {{ shortDate($resume['resume_date']) }}{{ $resume['primary'] ? '*' : '' }} ({{ $fileType }})
                                            </option>
                                        @endif

                                    @endforeach

                                @endforeach
                            </select>

                            @include('admin.components.form-button', [
                                'name'  => 'Attach',
                                'label' => 'Attach',
                                'id'    => 'attach-resume-button',
                                'class' => 'button is-small is-dark my-0 nav-button',
                                'style' => [ 'display: none' ],
                                'props' => !empty($resume->{$column})
                                    ? [ 'title' => 'Replace the current resume with this resume' ]
                                    : [ 'title' => 'Attach this resume to the application' ]
                            ])

                        </form>

                        <div style="display: inline-block; font-size: 0.8rem;">
                        <div style="display: inline-block; background-color: rgb(0, 209, 178); width: 12px; height: 12px;"></div> Indicates a primary resume.
                            An asterisk `*` indicates an active resume.
                        </div>

                        @include('admin.components.form-button', [
                            'name'  => 'all_active_resumes',
                            'label' => 'Show Only Active Resumes',
                            'id'    => 'all_active_resumes',
                            'title' => 'show only active resumes',
                            'class' => 'button is-small is-gray my-0 nav-button',
                            'style' => 'padding: 0 2px 0 2px',
                        ])

                    </div>
                </div>
            </div>

            @if (!empty($application['resume_datetime']))
                @include('admin.components.form-text-horizontal', [
                    'name'  => 'datetime',
                    'value' => longDateTime($application['resume_datetime']),
                ])
            @endif

            <iframe src="{{ $href }}"
                    id="application-resume-preview"
                    class="application-resume-preview"
                    @if (empty($fileExtension))
                        style="display: none;"
                    @endif
            >
            </iframe>

        </div>

    </div>

</div>

<script>

    document.addEventListener('DOMContentLoaded', () => {
        (document.querySelectorAll('.resume-filter-checkbox') || []).forEach((elem) => {
            elem.addEventListener('click', (event) => {
                const elem = event.target;
                const filterType = elem.getAttribute('filterType');

                if (event.target.checked) {
                    console.log('checked', `select.application-select-resume option[${filterType}="1"]`);
                    const a = document.querySelectorAll(`select.application-select-resume option[${filterType}="1"]`);
                    console.log(a);
                    (document.querySelectorAll(`select#application-select-resume option[${filterType}="1"]`) || []).forEach((elem) => {
                        elem.style.display = 'block';
                    });
                } else {
                    console.log('checked', `select.application-select-resume option[${filterType}="0"]`);
                    const a = document.querySelectorAll(`select.application-select-resume option[${filterType}="0"]`);
                    console.log(a);
                    (document.querySelectorAll(`select#application-select-resume option[${filterType}="0"]`) || []).forEach((elem) => {
                        elem.style.display = 'none';
                    });
                }

            })
        });

    });
</script>
