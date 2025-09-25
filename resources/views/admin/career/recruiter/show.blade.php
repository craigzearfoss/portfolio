@extends('admin.layouts.default', [
    'title' => $recruiter->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Recruiters',       'url' => route('admin.career.recruiter.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.career.recruiter.edit', $recruiter) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recruiter', 'url' => route('admin.career.recruiter.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => referer('admin.career.recruiter.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $recruiter->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $recruiter->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $recruiter->slug
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'postings url',
            'label'  => $recruiter->postings_url,
            'url'    => $recruiter->postings_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'local',
            'checked' => $recruiter->local
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'regional',
            'checked' => $recruiter->regional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'national',
            'checked' => $recruiter->national
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'international',
            'checked' => $recruiter->international
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'    => $recruiter->street ?? null,
                           'street2'   => $recruiter->street2 ?? null,
                           'city'      => $recruiter->city ?? null,
                           'state'     => $recruiter->state['code'] ?? null,
                           'zip'       => $recruiter->zip ?? null,
                           'country'   => $recruiter->country['iso_alpha3'] ?? null,
                       ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $recruiter->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $recruiter->longitude
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($recruiter->phone_label) ? $recruiter->phone_label : 'phone',
            'value' => $recruiter->phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($recruiter->alt_phone_label) ? $recruiter->alt_phone_label : 'alt phone',
            'value' => $recruiter->alt_phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($recruiter->email_label) ? $recruiter->email_label : 'email',
            'value' => $recruiter->email
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($recruiter->alt_email_label) ? $recruiter->alt_email_label : 'alt email',
            'value' => $recruiter->alt_email
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'label'  => $recruiter->link,
            'url'    => $recruiter->link_name,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $recruiter->description
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $recruiter->image,
            'alt'      => $recruiter->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($recruiter->name, $recruiter->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $recruiter->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $recruiter->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $recruiter->thumbnail,
            'alt'      => $recruiter->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($recruiter->name, $recruiter->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $recruiter->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $recruiter->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $recruiter->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $recruiter->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $recruiter->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $recruiter->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($recruiter->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($recruiter->updated_at)
        ])

    </div>

@endsection
