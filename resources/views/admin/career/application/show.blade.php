@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $application = $application ?? null;

    $title    = getResourcePageTitle($application);
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
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($application, false) ];

    // set navigation buttons
    $navButtons = [];
    $navButtons[] = view('admin.components.nav-button', [ 'name'  => 'Analyze Job Description',
                                                          'href'  => route('admin.career.application.analyze'),
                                                          'icon'  => 'fa-filter',
                                                          'class' => 'button is-small is-dark my-0 nav-button'
                                                        ])->render();
    if (canUpdate($application, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.application.edit', $application) ])->render();
    }
    if (canCreate($application, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Application',
                                                                  'href' => route('admin.career.application.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.application.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <section class="section">

        <div class="container show-container">
            <div class="columns is-12 is-variable">
                <div class="column is-12-tablet">

                    <!-- tabbed content -->
                    <div class="tabs is-boxed mb-0">
                        <ul style="border-bottom-width: 0 !important;">
                            <li id="initial-selected-tab" class="is-active" data-target="application-details">
                                <a>Details</a>
                            </li>
                            <li data-target="job-description">
                                <a>Description</a>
                            </li>
                            <li data-target="application-skill">
                                <a>Skills</a>
                            </li>
                            <li data-target="cover-letter">
                                <a>Cover Letter</a>
                            </li>
                            <li data-target="resume">
                                <a>Resume</a>
                            </li>
                            <li data-target="communications">
                                <a>Communications</a>
                            </li>
                            <li data-target="events">
                                <a>Events</a>
                            </li>
                            <li data-target="notes">
                                <a>Notes</a>
                            </li>
                        </ul>

                    </div>

                    <div class="px-2" id="tab-content">

                        <div id="application-details">

                            <div class="card p-4">

                                <h3 class="is-size-5 title mb-3">Details</h3>

                                <hr class="navbar-divider">
                                <div style="height: 12px; margin: 0; padding: 0;"></div>

                                <div class="floating-div-container">

                                    <div class="floating-div card has-background-white-ter p-4 m-2">

                                        @include('admin.components.show-row', [
                                            'name'  => 'id',
                                            'value' => $application->id,
                                            'hide'  => !$isRootAdmin,
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $application->owner->username,
                                            'hide'  => !$isRootAdmin,
                                        ])

                                        <?php /*
                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => htmlspecialchars($application->name)
                                        ])
                                        */ ?>

                                        @include('admin.components.show-row-checkmark', [
                                            'name'    => 'active',
                                            'checked' => $application->active
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'company',
                                            'value' =>  view('admin.components.link', [
                                                'name' => htmlspecialchars($application->company['name'] ?? ''),
                                                'href' => !empty($application->company)
                                                    ? route('admin.career.company.show', $application->company['id'])
                                                    : '',
                                            ])
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'role',
                                            'value' => htmlspecialchars($application->role)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'reference id',
                                            'value' => $application->reference_id
                                        ])

                                        @include('admin.components.show-row-rating', [
                                            'name'  => 'rating',
                                            'value' => $application->rating
                                        ])

                                    </div>

                                    <div class="floating-div card has-background-white-ter p-4 m-2">

                                        @include('admin.components.show-row', [
                                            'name'  => 'compensation',
                                            'value' => formatCompensation([
                                                'min'   => $application->compensation_min,
                                                'max'   => $application->compensation_max,
                                                'unit'  => $application->compensationUnit['name'] ?? '',
                                            ])
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'wage',
                                            'value' => wageRateFormat($application->wage_rate)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'duration',
                                            'value' => formatJobDuration(
                                                $application->durationType['name'] ?? null,
                                                $application->job_duration_length,
                                                $application->durationUnit['name'] ?? null,
                                            )
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'employment',
                                            'value' => $application->employmentType['name'] ?? ''
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'location',
                                            'value' => $application->locationType['name'] ?? ''
                                        ])


                                    </div>

                                    <div class="floating-div card has-background-white-ter p-4 m-2">

                                        @include('admin.components.show-row-checkmark', [
                                            'name'    => 'w2',
                                            'checked' => $application->w2
                                        ])

                                        @include('admin.components.show-row-checkmark', [
                                            'name'    => 'relocation',
                                            'checked' => $application->relocation
                                        ])

                                        @include('admin.components.show-row-checkmark', [
                                            'name'    => 'benefits',
                                            'checked' => $application->benefits
                                        ])

                                        @include('admin.components.show-row-checkmark', [
                                            'name'    => 'vacation',
                                            'checked' => $application->vacation
                                        ])

                                        @include('admin.components.show-row-checkmark', [
                                            'name'    => 'health',
                                            'checked' => $application->health
                                        ])

                                        @include('admin.components.show-row-checkmark', [
                                            'name'    => '401(k)',
                                            'checked' => $application->fouroonek
                                        ])

                                         @if (!empty($application->bonus))
                                            @include('admin.components.show-row', [
                                                'name'  => 'bonus',
                                                'value' => htmlspecialchars($application->bonus)
                                            ])
                                        @endif

                                    </div>

                                    <div class="floating-div card has-background-white-ter p-4 m-2" style="float: right">

                                        @include('admin.components.show-row', [
                                            'name'         => 'post date',
                                            'value'        => longDate($application->post_date),
                                            'width'        => '20em',
                                            'whiteSpace'   => 'nowrap',
                                            'margin-right' => '2px',
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'         => 'apply date',
                                            'value'        => longDate($application->apply_date),
                                            'width'        => '20em',
                                            'whiteSpace'   => 'nowrap',
                                            'margin-right' => '2px',
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'       => 'close date',
                                            'value'      => longDate($application->close_date),
                                            'whiteSpace' => 'nowrap',
                                            'width'      => '20em',
                                        ])

                                        @php
                                            $jobBoardLinks = [];
                                            if (!empty($application->jobBoard)) {
                                                $jobBoardLinks[] = view('admin.components.link', [
                                                    'name' => htmlspecialchars($application->jobBoard['name'] ?? ''),
                                                    'href' => route('admin.career.job-board.show', $application->jobBoard['id']),
                                                ]);
                                            }

                                            if (!empty($application->jobBoard2)) {
                                                $jobBoardLinks[] = view('admin.components.link', [
                                                    'name' => htmlspecialchars($application->jobBoard2['name'] ?? ''),
                                                    'href' => route('admin.career.job-board.show', $application->jobBoard2['id']),
                                                ]);
                                            }
                                        @endphp

                                        @include('admin.components.show-row', [
                                            'name'  => 'job board(s)',
                                            'value' => implode(', ', $jobBoardLinks)
                                        ])

                                    </div>

                                </div>
                                <div class="floating-div-container">

                                    <div class="floating-div card has-background-white-ter p-4 m-2" style="display: inline-block;">

                                        <div class="mr-4" style="display: inline-block; min-width: 20rem; vertical-align: top;">

                                            @include('admin.components.show-row', [
                                                'name'  => 'location',
                                                'value' => formatLocation([
                                                   'street'          => htmlspecialchars($application->street),
                                                   'street2'         => htmlspecialchars($application->street2),
                                                   'city'            => htmlspecialchars($application->city),
                                                   'state'           => $application->state->code ?? '',
                                                   'zip'             => htmlspecialchars($application->zip),
                                                   'country'         => $application->country->iso_alpha3 ?? '',
                                                   'streetSeparator' => '<br>',
                                               ])
                                            ])

                                            @if (!empty($application->latitude) || !empty($application->longitude))
                                                @include('admin.components.show-row-coordinates', [
                                                    'resource' => $application
                                                ])
                                            @endif

                                        </div>
                                        <div class="mr-4" style="display: inline-block; min-width: 15rem; vertical-align: top;">

                                            @include('admin.components.show-row', [
                                                'name'  => !empty($application->phone_label) ? htmlspecialchars($application->phone_label) : 'phone',
                                                'value' => htmlspecialchars($application->phone)
                                            ])

                                            @include('admin.components.show-row', [
                                                'name'  => !empty($application->alt_phone_label) ?  htmlspecialchars($application->alt_phone_label) : 'alt phone',
                                                'value' => htmlspecialchars($application->alt_phone)
                                            ])

                                            @include('admin.components.show-row', [
                                                'name'  => !empty($application->email_label) ?  htmlspecialchars($application->email_label) : 'email',
                                                'value' =>  htmlspecialchars($application->email)
                                            ])

                                            @include('admin.components.show-row', [
                                                'name'  => !empty($application->alt_email_label) ?  htmlspecialchars($application->alt_email_label) : 'alt email',
                                                'value' =>  htmlspecialchars($application->alt_email)
                                            ])

                                        </div>

                                    </div>
                                    <div class="floating-div card has-background-white-ter p-4 m-2" style="display: inline-block;">

                                        @include('admin.components.show-row-images', [
                                            'resource' => $application,
                                            'upload'   => true,
                                            'download' => true,
                                            'external' => true,
                                        ])

                                    </div>

                                </div>

                                <div class="floating-div-container">

                                    <div class="floating-div card has-background-white-ter p-4 m-2">

                                        @include('admin.components.show-row', [
                                            'name'  => 'disclaimer',
                                            'value' => view('admin.components.disclaimer', [
                                                            'value' => htmlspecialchars($application->disclaimer)
                                                       ])
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'notes',
                                            'value' => nl2br(htmlspecialchars($application->notes))
                                        ])
                                        <div style="white-space: nowrap;">
                                            @include('admin.components.show-row-visibility', [
                                                'resource' => $application,
                                            ])
                                        </div>

                                        @include('admin.components.show-row', [
                                            'name'  => 'created at',
                                            'value' => longDateTime($application->created_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'updated at',
                                            'value' => longDateTime($application->updated_at)
                                        ])

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div id="job-description" class="is-hidden">
                            @include('admin.career.application.job-description.panel', [
                                'application'       => $application ?? null,
                            ])
                        </div>

                        <div id="application-skill" class="is-hidden">
                            @include('admin.career.application.application-skill.panel', [
                                'application'       => $application ?? null,
                                'matchedSkills'     => $matchedSkills ?? [],
                                'matchedAntiSkills' => $matchedAntiSkills ?? [],
                                'parsedDescription' => $parsedDescription ?? ''
                            ])
                        </div>

                        <div id="cover-letter" class="is-hidden">
                            @include('admin.career.application.cover-letter.panel', [
                                'coverLetter'   => $application->coverLetter ?? null,
                                'applicationId' => $application->id ?? null,
                            ])
                        </div>

                        <div id="resume" class="is-hidden">
                            @include('admin.career.application.resume.panel', [
                                'application' => $application ?? null,
                            ])
                        </div>

                        <div id="communications" class="is-hidden">
                            @include('admin.career.application.communication.panel', [
                                'communications' => $application->communications ?? [],
                                'links' => [
                                    'add' => route('admin.career.communication.create', ['application_id' => $application->id])
                                ]
                            ])
                        </div>

                        <div id="events" class="is-hidden">
                            @include('admin.career.application.event.panel', [
                                'events' => $application->events ?? [],
                                'links'  => [
                                    'add' => route('admin.career.event.create', ['application_id' => $application->id])
                                ]
                            ])
                        </div>

                        <div id="notes" class="is-hidden">
                            @include('admin.career.application.note.panel', [
                                'notes' => $application->application_notes ?? [],
                                'links' => [
                                    'add' => route('admin.career.note.create', ['application_id' => $application->id])
                                ]
                            ])
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
