@extends('admin.layouts.default', [
    'title' => $company->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Companies',       'href' => route('admin.career.company.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.career.company.edit', $company) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Company', 'url' => route('admin.career.company.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => referer('admin.career.company.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $company->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $company->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $company->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $company->slug
        ])

        @include('admin.components.company.contacts-panel', [
            'contacts' => $company->contacts ?? [],
            'company'  => $company
        ])

        @include('admin.components.show-row', [
            'name'  => 'industry',
            'value' => $company->industry['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                'street'    => $company->street ?? null,
                'street2'   => $company->street2 ?? null,
                'city'      => $company->city ?? null,
                'state'     => $company->state['code'] ?? null,
                'zip'       => $company->zip ?? null,
                'country'   => $company->country['iso_alpha3'] ?? null,
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $company->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $company->longitude
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($company->phone_label) ? $company->phone_label : 'phone',
            'value' => $company->phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($company->alt_phone_label) ? $company->alt_phone_label : 'alt phone',
            'value' => $company->alt_phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($company->email_label) ? $company->email_label : 'email',
            'value' => $company->email
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($company->alt_email_label) ? $company->alt_email_label : 'alt email',
            'value' => $company->alt_email
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $company->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $company->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $company->description
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $company->image,
            'alt'      => $company->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($company->name, $company->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $company->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $company->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $company->thumbnail,
            'alt'      => $company->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($company->name, $company->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $company->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $company->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $company->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $company->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $company->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($company->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($company->updated_at)
        ])

    </div>

@endsection
