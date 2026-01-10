@php
    $buttons = [];
    if (canUpdate($publication, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.publication.edit', $publication) ];
    }
    if (canCreate($publication, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Publication', 'href' => route('admin.portfolio.publication.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.publication.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Publication: ' . $publication->title,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Publications',    'href' => route('admin.portfolio.publication.index') ],
        [ 'name' => $publication->title ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => htmlspecialchars($publication->title ?? '')
        ])

        @if(!empty($publication->parent))
            @include('admin.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($publication->parent)
                    ? view('admin.components.link', [
                            'name' => htmlspecialchars($publication->parent->title ?? ''),
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
            'value' => $publication->summary ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'publication name',
            'value' => htmlspecialchars($publication->publication_name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'publisher',
            'value' => htmlspecialchars($publication->publisher ?? '')
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
            'value' => htmlspecialchars($publication->credit ?? '')
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
            'value' => htmlspecialchars($publication->publication_url ?? ''),
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $publication->notes ?? ''
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($publication->link_name ?? 'link'),
            'href'   => htmlspecialchars($publication->link, ''),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $publication->description ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => htmlspecialchars($publication->disclaimer ?? '')
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $publication,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $publication,
        ])

    </div>

@endsection
