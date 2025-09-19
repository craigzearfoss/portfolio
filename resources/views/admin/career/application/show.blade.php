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
    'errors'  => $errors->any() ?? [],
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
            'value' => !empty($application->company)
                ? $application->company_id . ' - <a href="' . route('admin.career.company.show', $application->company) . '">' . $application->company['name'] . '</a>'
                : ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'cover letter',
            'value' => !empty($application->cover_letter)
                ? $application->cover_letter_id . ' - <a href="' . route('admin.career.cover-letter.show', $application->cover_letter) . '">' . $application->cover_letter['name'] . '</a>'
                : ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'resume',
            'value' => !empty($application->resume)
                ? $application->resume_id . ' - <a href="' . route('admin.career.resume.show', $application->resume) . '">' . $application->resume['name'] . '</a>'
                : ''
        ])

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
            'value' => $application->job_board_id
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

@endsection
