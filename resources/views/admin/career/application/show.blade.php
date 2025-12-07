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
                'value' => htmlspecialchars($application->owner['username'] ?? '')
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
               'street'    => htmlspecialchars($application->street ?? ''),
               'street2'   => htmlspecialchars($application->street2 ?? ''),
               'city'      => htmlspecialchars($application->city ?? ''),
               'state'     => $application->state['code'] ?? null,
               'zip'       => htmlspecialchars($application->zip ?? ''),
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
            'value' => $application->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($application->link_name ?? 'link'),
            'href'   => $application->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => htmlspecialchars($application->description)
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $application->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $application->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($application->name, $application->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($application->image_credit)
        ])

        @include('admin.components.form-image-horizontal', [
            'image'   => old('image') ?? $application->image,
            'credit'  => old('image_credit') ?? $application->image_credit,
            'source'  => old('image_source') ?? $application->image_source,
            'message' => $message ?? '',
        ])


        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($application->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $application->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($application->name . '-thumb', $application->thumbnail)
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
        'notes' => $application->application_notes ?? [],
        'links' => [
            'add' => route('admin.career.note.create', ['application_id' => $application->id])
        ]
    ])

@endsection
