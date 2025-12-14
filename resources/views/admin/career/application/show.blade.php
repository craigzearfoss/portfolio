@php
    $buttons = [];
    if (canUpdate($application)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.application.edit', $application) ];
    }
    if (canCreate($application)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Application', 'href' => route('admin.career.application.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.career.application.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'Application: ' . $application->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',    'href' => route('admin.career.application.index') ],
        [ 'name' => $application->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',            'href' => route('admin.career.application.edit', $application) ],
        [ 'name' => '<i class="fa fa-plus"></i> Create a New Application', 'href' => route('admin.career.application.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',               'href' => referer('admin.career.application.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $application->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => htmlspecialchars($application->owner->username ?? '')
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($application->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' =>  view('admin.components.link', [
                'name' => $application->company['name'] ?? '',
                'href' => !empty($application->company)
                    ?route('admin.career.company.show', $application->company['id'])
                    : '',
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => htmlspecialchars($application->role)
        ])

        <div class="container card p-2 mb-2" style="display: inline-block; flex-grow: 0;">

            <div class="p-2 m-0" style="display: inline-block; flex-grow: 0;">
                @include('admin.components.show-row', [
                    'name'         => 'post date',
                    'value'        => longDate($application->post_date),
                    'width'        => '20em',
                    'whiteSpace'   => 'nowrap',
                    'margin-right' => '2px',
                ])
            </div>

            <div class="p-2 m-0" style="display: inline-block; flex-grow: 0;">
                @include('admin.components.show-row', [
                    'name'         => 'apply date',
                    'value'        => longDate($application->apply_date),
                    'width'        => '20em',
                    'whiteSpace'   => 'nowrap',
                    'margin-right' => '2px',
                ])
            </div>

            <div class="p-2 m-0" style="display: inline-block; flex-grow: 0;">
                @include('admin.components.show-row', [
                    'name'       => 'close date',
                    'value'      => longDate($application->close_date),
                    'whiteSpace' => 'nowrap',
                    'width'      => '20em',
                ])
            </div>

        </div>

        <div class="row mb-2" style="flex-grow: 0;">

            @include('admin.career.application.cover-letter.panel', [
                'coverLetter'   => $application->coverLetter ?? null,
                'applicationId' => $application->id ?? null,
            ])

            @include('admin.career.application.resume.panel', [
                'resume'        => $application->resume ?? null,
                'applicationId' => $application->id ?? null,
            ])

        </div>

        @include('admin.components.show-row-rating', [
            'name'  => 'rating',
            'value' => $application->rating
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'active',
            'checked' => $application->active
        ])


        @include('admin.components.show-row', [
            'name'  => 'compensation',
            'value' => formatCompensation([
                'min'   => $application->compensation_min ?? '',
                'max'   => $application->compensation_max ?? '',
                'unit'  => $application->compensationUnit['name'] ?? '',
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'duration type',
            'value' => $application->durationType['name']
        ])

        @include('admin.components.show-row', [
            'name'  => 'employment type',
            'value' => $application->employmentType['name'] ?? '',
        ])

        @include('admin.components.show-row', [
            'name'  => 'location type',
            'value' => $application->locationType['name'] ?? '',
        ])

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

        @include('admin.components.show-row-coordinates', [
            'resource' => $application
        ])

        @include('admin.components.show-row', [
            'name'  => 'bonus',
            'value' => !empty($application->bonus) ? '$' . htmlspecialchars($application->bonus) : ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'w2',
            'checked' => $application->w2
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'relocation',
            'checked' => $application->relocation
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'benefits',
            'checked' => $application->benefits
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'vacation',
            'checked' => $application->vacation
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'health',
            'checked' => $application->health
        ])

        @include('admin.components.show-row', [
            'name'  => 'source',
            'value' => view('admin.components.link', [
                'name' => $application->jobBoard['name'] ?? '',
                'href' => !empty($application->jobBoard)
                    ? route('admin.career.job-board.show', $application->jobBoard['id'])
                    : '',
            ])
        ])

        <div class="columns">
            <div class="column is-6">

                <table>
                    <tbody>
                        <tr>
                            <td><strong>{{ !empty($application->phone_label) ? $application->phone_label : 'phone' }}</strong></td>
                            <td>{{ $application->phone }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ !empty($application->alt_phone_label) ? $application->alt_phone_label : 'alt phone' }}</strong></td>
                            <td>{{ $application->alt_phone }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="column is-6">

                <table>
                    <tbody>
                    <tr>
                        <td><strong>{{ !empty($application->email_label) ? $application->email_label : 'email' }}</strong></td>
                        <td>{{ $application->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ !empty($application->alt_email_label) ? $application->alt_email_label : 'alt email' }}</strong></td>
                        <td>{{ $application->alt_email }}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($application->notes))
        ])

        @if(!empty($application->link))
            @include('admin.components.show-row-link', [
                'name'   => $application->link_name,
                'href'   => $application->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($application->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $application->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $application,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $application,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($application->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($application->updated_at)
        ])

    </div>

    @include('admin.career.application.communication.panel', [
        'communications' => $application->communications ?? [],
        'links' => [
            'add' => route('admin.career.communication.create', ['application_id' => $application->id])
        ]
    ])

    @include('admin.career.application.event.panel', [
        'events' => $application->events ?? [],
        'links'  => [
            'add' => route('admin.career.event.create', ['application_id' => $application->id])
        ]
    ])

    @include('admin.career.application.note.panel', [
        'notes' => $application->application_notes ?? [],
        'links' => [
            'add' => route('admin.career.note.create', ['application_id' => $application->id])
        ]
    ])

@endsection
