@extends('admin.layouts.default', [
    'title' => 'Application',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',    'href' => route('admin.career.application.index') ],
        [ 'name' => 'Show' ],
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
                'value' => $application->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $application->name
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
            'value' => $application->role
        ])


        <div class="card p-4">
            @include('admin.components.show-row', [
                'name'  => 'cover letter',
                'value' => view('admin.components.link', [
                    'name'  => 'Show',
                    'href'  => route('admin.career.application.cover-letter.show', $application),
                    'class' => 'button is-primary is-small px-1 py-0'
                ])
            ])
            @include('admin.components.show-row', [
                'name'  => 'cover letter date',
                'value' => longDate($application->cover_letter['date'])
            ])

            @include('admin.components.show-row', [
                'name'  => 'cover letter url',
                'value' => empty($application->cover_letter['cover_letter_url'])
                    ? view('admin.components.link', [
                            'name'   => 'Attach',
                            'href'   => route('admin.career.application.cover-letter.edit', $application->cover_letter),
                            'class'  => 'button is-primary is-small px-1 py-0'
                        ])
                    : view('admin.components.link', [
                            'name'   => 'View',
                            'href'   => $application->cover_letter['cover_letter_url'],
                            'target' => '_blank',
                            'class'  => 'button is-primary is-small px-1 py-0'
                        ])
            ])

        </div>

        <h1 class="subtitle">@TODO: resume</h1>

        @include('admin.components.show-row-rating', [
            'name'  => 'rating',
            'value' => $application->rating
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'active',
            'checked' => $application->active
        ])

        @include('admin.components.show-row', [
            'name'  => 'post date',
            'value' => longDate($application->post_date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'apply date',
            'value' => longDate($application->apply_date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'close date',
            'value' => longDate($application->close_date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'compensation',
            'value' => formatCompensation([
                'min'   => $application->compensation_min ?? '',
                'max'   => $application->compensation_max ?? '',
                'unit'  => $application->compensation_unit['name'] ?? '',
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'duration',
            'value' => $application->duration['name']
        ])

        @include('admin.components.show-row', [
            'name'  => 'office',
            'value' => \App\Models\Career\ApplicationOffice::find($application->office_id)->name ?? '',
        ])

        @include('admin.components.show-row', [
            'name'  => 'schedule',
            'value' => \App\Models\Career\ApplicationSchedule::find($application->schedule_id)->name ?? '',
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
               'street'    => $application->street ?? null,
               'street2'   => $application->street2 ?? null,
               'city'      => $application->city ?? null,
               'state'     => $application->state['code'] ?? null,
               'zip'       => $application->zip ?? null,
               'country'   => $application->country['iso_alpha3'] ?? null,
           ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $application->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $application->longitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'bonus',
            'value' => !empty($application->bonus) ? '$' . $application->bonus : ''
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
                'name' => $application->job_board['name'] ?? '',
                'href' => !empty($application->job_board)
                    ? route('admin.career.job-board.show', $application->job_board['id'])
                    : '',
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($application->phone_label) ? $application->phone_label : 'phone',
            'value' => $application->phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($application->alt_phone_label) ? $application->alt_phone_label : 'alt phone',
            'value' => $application->alt_phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($application->email_label) ? $application->email_label : 'email',
            'value' => $application->email
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($application->alt_email_label) ? $application->alt_email_label : 'alt email',
            'value' => $application->alt_email
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $application->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $application->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $application->description
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $application->image,
            'alt'      => $application->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($application->name, $application->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $application->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $application->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $application->thumbnail,
            'alt'      => $application->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($application->name, $application->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $application->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $application->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $application->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $application->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $application->disabled
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
        'notes' => $application->notes ?? [],
        'links' => [
            'add' => route('admin.career.note.create', ['application_id' => $application->id])
        ]
    ])

@endsection
