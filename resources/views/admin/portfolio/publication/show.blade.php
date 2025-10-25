@extends('admin.layouts.default', [
    'title' => 'Publication: ' . $publication->title,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Publications',    'href' => route('admin.portfolio.publication.index') ],
        [ 'name' => $publication->title ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',       'href' => route('admin.portfolio.publication.edit', $publication) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Publication', 'href' => route('admin.portfolio.publication.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',          'href' => referer('admin.portfolio.publication.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $publication->title
        ])

        @if(!empty($publication->parent))
            @include('admin.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($publication->parent)
                    ? view('admin.components.link', [
                            'name' => $publication->parent['title'],
                            'href' => route('admin.portfolio.publication.show', $publication->parent->slug)
                        ])
                    : ''
            ])
        @endif

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $publication->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $publication->summary
        ])

        @include('admin.components.show-row', [
            'name'  => 'publication name',
            'value' => $publication->publication_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'publisher',
            'value' => $publication->publisher
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($publication->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $publication->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'credit',
            'value' => $publication->credit
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'freelance',
            'checked' => $publication->freelance
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'fiction',
            'checked' => $publication->fiction
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'nonfiction',
            'checked' => $publication->nonfiction
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'technical',
            'checked' => $publication->technical
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'research',
            'checked' => $publication->research
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'poetry',
            'checked' => $publication->poetry
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'online',
            'checked' => $publication->online
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'novel',
            'checked' => $publication->novel
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'book',
            'checked' => $publication->book
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'textbook',
            'checked' => $publication->textbook
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'article',
            'checked' => $publication->article
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'paper',
            'checked' => $publication->paper
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'pamphlet',
            'checked' => $publication->pamphlet
        ])

        @include('admin.components.show-row', [
            'name'  => 'publication url',
            'value' => $publication->publication_url,
        ])

        @if(!empty($publication->link))
            @include('admin.components.show-row-link', [
                'name'   => $publication->link_name,
                'href'   => $publication->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($publication->description ?? '')
        ])

        @if(!empty($publication->image))

            @include('admin.components.show-row-image', [
                'name'     => 'image',
                'src'      => $publication->image,
                'alt'      => $publication->name . ', ' . $publication->artist,
                'width'    => '300px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($publication->name . '-by-' . $publication->artist, $publication->image)
            ])

            @if(!empty($publication->image_credit))
                @include('admin.components.show-row', [
                    'name'  => 'image credit',
                    'value' => $publication->image_credit
                ])
            @endif

            @if(!empty($publication->image_source))
                @include('admin.components.show-row', [
                    'name'  => 'image source',
                    'value' => $publication->image_source
                ])
            @endif

        @endif

        @if(!empty($publication->thumbnail))

            @include('admin.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $publication->thumbnail,
                'alt'      => $publication->name . ', ' . $publication->artist,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($publication->name . '-by-' . $publication->artist, $publication->thumbnail)
            ])

        @endif

    </div>

@endsection
