@extends('admin.layouts.default', [
    'title' => 'Application',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Applications',    'url' => route('admin.career.application.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',       'url' => route('admin.career.application.edit', $application) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Application', 'url' => route('admin.career.application.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',          'url' => referer('admin.career.application.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $application->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' =>  view('admin.components.link', [
                'url'  => !empty($application->company)
                    ?route('admin.career.company.show', $application->company['id'])
                    : '',
                'name' => $application->company['name'] ?? ''
            ])
        ])

        @if(!empty($application->cover_letter))
            @include('admin.components.show-row', [
                'name'  => 'cover letter',
                'value' => view('admin.components.link', [
                    'url'  => route('admin.career.cover-letter.show', $application->cover_letter['id']),
                    'name' => $application->cover_letter['name'] ?? ''
                ])
            ])
        @else
            @include('admin.components.show-row', [
                'name'  => 'cover letter',
                'value' => view('admin.components.link', [
                    'name'  => 'Attach a cover letter',
                    'url'   => route('admin.career.cover-letter.create', ['application_id' => $application->id]),
                    'class' => 'button is-primary is-small px-1 py-0',
                    'icon'  => 'fa-plus'
                ])
            ])
        @endif

        <h1 class="subtitle">@TODO: resume</h1>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $application->role
        ])

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
            'name'  => 'min compensation',
            'value' => $application->compensation_min,
            'unit'  => $application->compensation_unit
        ])

        @include('admin.components.show-row-compensation', [
            'name'  => 'max compensation',
            'value' => $application->compensation_max,
            'unit'  => $application->compensation_unit
        ])

        @include('admin.components.show-row', [
            'name'  => 'duration',
            'value' => $application->duration
        ])

        @include('admin.components.show-row', [
            'name'  => 'type',
            'value' => $application->type
        ])

        @include('admin.components.show-row', [
            'name'  => 'office',
            'value' => $application->office
        ])

        @include('admin.components.show-row', [
            'name'  => 'street',
            'value' => $application->street
        ])

        @include('admin.components.show-row', [
            'name'  => 'street2',
            'value' => $application->street2
        ])

        @include('admin.components.show-row', [
            'name'  => 'city',
            'value' => $application->city
        ])

        @include('admin.components.show-row', [
            'name'  => 'state',
            'value' => $application->state
        ])

        @include('admin.components.show-row', [
            'name'  => 'zip',
            'value' => $application->zip
        ])

        @include('admin.components.show-row', [
            'name'  => 'country',
            'value' => $application->country
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $application->longitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $application->latitude
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
            'name'  => 'job board',
            'value' => view('admin.components.link', [
                'url' => !empty($application->job_board)
                    ? route('admin.career.job-board.show', $application->job_board['id'])
                    : '',
                'name' => $application->job_board['name'] ?? '',
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
            'label'  => $application->link_name,
            'url'    => $application->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $application->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $application->image,
            'alt'   => $application->name,
            'width' => '300px',
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
            'name'  => 'thumbnail',
            'src'   => $application->thumbnail,
            'alt'   => $application->name,
            'width' => '40px',
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
            'name'  => 'owner',
            'value' => $application->admin['username'] ?? ''
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

    @include('admin.components.application.communications-panel', [
        'communications' => $application->communications,
        'links' => [
            'add' => route('admin.career.communication.create', ['application_id' => $application->id])
        ]
    ])

    @include('admin.components.application.events-panel', [
        'events' => $application->events,
        'links'  => [
            'add' => route('admin.career.event.create', ['application_id' => $application->id])
        ]
    ])

    @include('admin.components.application.notes-panel', [
        'notes' => $application->notes,
        'links' => [
            'add' => route('admin.career.note.create', ['application_id' => $application->id])
        ]
    ])

@endsection
