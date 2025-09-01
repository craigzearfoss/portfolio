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
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',          'url' => route('admin.career.application.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>


        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $application->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $application->role
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => !empty($application->company)
                ? '<a href="' . route('admin.career.company.show', $application->company['id']) . '">' . $application->company['name'] . '</a>'
                : ''
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
            'name'  => 'cover letter',
            'value' => $application->cover_letter['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'resume',
            'value' => $application->resume['name'] ?? ''
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

        @include('admin.components.show-row-compensation', [
            'name'  => 'compensation',
            'value' => $application->compensation,
            'unit'  => $application->compensation_unit
        ])

        @include('admin.components.show-row', [
            'name'  => 'duration',
            'value' => $application->duration
        ])

        @include('admin.components.show-row', [
            'name'  => 'type',
            'value' => \App\Models\Career\Application::typeName($application->type)
        ])

        @include('admin.components.show-row', [
            'name'  => 'office',
            'value' => \App\Models\Career\Application::officeName($application->office)
        ])

        @include('admin.components.show-row', [
            'name'  => 'city',
            'value' => $application->city
        ])

        @include('admin.components.show-row', [
            'name'  => 'state',
            'value' => \App\Models\State::getName($application->state)
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
            'value' => $application->source
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $application->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'contact(s)',
            'value' => $application->contacts
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone(s)',
            'value' => $application->phones
        ])

        @include('admin.components.show-row', [
            'name'  => 'emails(s)',
            'value' => $application->emails
        ])

        @if (!empty($application->website))
            @include('admin.components.show-row-link', [
                'name'   => 'website',
                'url'    => $application->website,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $application->description
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $application->public
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

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($application->deleted_at)
        ])

    </div>

@endsection
