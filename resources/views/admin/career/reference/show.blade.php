@extends('admin.layouts.default', [
    'title' => 'Reference: ' . $reference->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'References',      'href' => route('admin.career.reference.index') ],
        [ 'name' => $reference->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',     'href' => route('admin.career.reference.edit', $reference) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Reference', 'href' => route('admin.career.reference.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',        'href' => referer('admin.career.reference.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card form-container p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $reference->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $reference->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $reference->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $reference->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'relation',
            'value' => $reference->relation ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $reference->company['name'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                'street'    => $reference->street ?? null,
                'street2'   => $company->street2 ?? null,
                'city'      => $reference->city ?? null,
                'state'     => $reference->state['code'] ?? null,
                'zip'       => $reference->zip ?? null,
                'country'   => $reference->country['iso_alpha3'] ?? null,
            ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'latitude',
            'value' => $reference->latitude
        ])

        @include('admin.components.show-row', [
            'name'  => 'longitude',
            'value' => $reference->longitude
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->phone_label) ? $reference->phone_label : 'phone',
            'value' => $reference->phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->alt_phone_label) ? $reference->alt_phone_label : 'alt phone',
            'value' => $reference->alt_phone
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->email_label) ? $reference->email_label : 'email',
            'value' => $reference->email
        ])

        @include('admin.components.show-row', [
            'name'  => !empty($reference->alt_email_label) ? $reference->alt_email_label : 'alt email',
            'value' => $reference->alt_email
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($reference->birthday)
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $reference->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $reference->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link name',
            'value'    => $reference->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($reference->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $reference->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $reference->image,
            'alt'      => $reference->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($reference->name, $reference->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $reference->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $reference->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $reference->thumbnail,
            'alt'      => $reference->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($reference->name, $reference->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $reference->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $reference->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $reference->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $reference->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $reference->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($reference->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($reference->updated_at)
        ])

    </div>

@endsection
