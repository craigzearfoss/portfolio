@extends('admin.layouts.default', [
    'title' => 'Award: ' . $award->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Award',           'href' => route('admin.portfolio.award.index') ],
        [ 'name' => $award->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.award.edit', $award) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Award', 'href' => route('admin.portfolio.award.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.award.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $award->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $award->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($award->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'category',
            'value' => htmlspecialchars($award->category)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($award->nominated_work)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $award->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $award->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => htmlspecialchars($award->summary)
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $award->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'date received',
            'value' => longDate($award->received)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $award->image_url,
            'width'    => '300px',
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($award->notes))
        ])

        @if(!empty($award->link))
            @include('admin.components.show-row-link', [
                'name'   => $award->link_name,
                'href'   => $award->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($award->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $award->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $award->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($award->name), $award->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($award->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($award->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $award->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($award->name) . '-thumb', $award->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $award->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $award->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $award->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $award->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $award->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($award->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($award->updated_at)
        ])

    </div>

@endsection
