@extends('admin.layouts.default', [
    'title' => 'Company: ' . $company->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Companies',       'href' => route('admin.career.company.index') ],
        [ 'name' => $company->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'href' => route('admin.career.company.edit', $company) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Company', 'href' => route('admin.career.company.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'href' => referer('admin.career.company.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $company->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $company->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($company->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $company->slug
        ])

        @include('admin.career.company.contact.panel', [
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
                'street'          => htmlspecialchars($company->street),
                'street2'         => htmlspecialchars($company->street2),
                'city'            => htmlspecialchars($company->city),
                'state'           => $company->state->code ?? '',
                'zip'             => htmlspecialchars($company->zip),
                'country'         => $company->country->iso_alpha3 ?? '',
                'streetSeparator' => '<br>',
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
            'name'  => htmlspecialchars(!empty($company->phone_label) ? $company->phone_label : 'phone'),
            'value' => htmlspecialchars($company->phone)
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($company->alt_phone_label) ? $company->alt_phone_label : 'alt phone'),
            'value' => htmlspecialchars($company->alt_phone)
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($company->email_label) ? $company->email_label : 'email'),
            'value' => htmlspecialchars($company->email)
        ])

        @include('admin.components.show-row', [
            'name'  => htmlspecialchars(!empty($company->alt_email_label) ? $company->alt_email_label : 'alt email'),
            'value' => htmlspecialchars($company->alt_email)
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $company->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($company->link_name ?? 'link'),
            'href'   => $company->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $company->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $company->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $company->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($company->name, $company->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($company->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($company->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $company->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($company->name . '-thumb', $company->thumbnail)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'logo',
            'src'   => $company->logo,
            'alt'   => 'logo',
            'width' => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($company->name . '-logo', $company->logo)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'logo small',
            'src'   => $company->logo_small,
            'alt'   => 'logo small',
            'width' => '100px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($company->name . '-logo-sm', $company->logo_small)
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
