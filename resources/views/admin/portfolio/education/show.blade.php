@extends('admin.layouts.default', [
    'title' => 'Education: ' . $education->degreeType->name . ' ' . $education->major,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Education',       'href' => route('admin.portfolio.education.index') ],
        [ 'name' => $education->degreeType->name . ' ' . $education->major ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',     'href' => route('admin.portfolio.education.edit', $education) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Education', 'href' => route('admin.portfolio.education.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',        'href' => referer('admin.portfolio.education.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $education->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $education->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'degree type',
            'value' => $education->degreeType->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'major',
            'value' => $education->major ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'minor',
            'value' => $education->minor ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'school',
            'value' => $education->school->name ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $education->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'enrollment',
            'value' => (!empty($education->enrollment_month) ? date('F', mktime(0, 0, 0, $education->enrollment_month, 10)) : '') . ' ' . $education->enrollment_year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'graduated',
            'checked' => $education->graduated
        ])

        @include('admin.components.show-row', [
            'name'  => 'enrollment',
            'value' => (!empty($education->graduation_month) ? date('F', mktime(0, 0, 0, $education->graduation_month, 10)) : '') . ' ' . $education->graduation_year
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'currently enrolled',
            'checked' => $education->currently_enrolled
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $education->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $education->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $education->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $education->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($education->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $education->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => imageUrl($education->image),
            'alt'      => $education->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($education->name, $education->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $education->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $education->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => imageUrl($education->thumbnail),
            'alt'      => $education->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($education->name, $education->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $education->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $education->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $education->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $education->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $education->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($education->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($education->updated_at)
        ])

    </div>

@endsection
