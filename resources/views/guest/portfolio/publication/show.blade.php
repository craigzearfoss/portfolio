@extends('guest.layouts.default', [
    'title' => $title ?? 'Publication: ' . $publication->title,
    'breadcrumbs' => [
        [ 'name' => 'Home',         'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio',    'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Publications', 'href' => route('guest.portfolio.publication.index') ],
        [ 'name' => $publication->title ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.personal.publication.index') ],
    ],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'title',
            'value' => $publication->title
        ])

        @if(!empty($publication->parent))
            @include('guest.components.show-row', [
                'name'  => 'parent',
                'value' => !empty($publication->parent)
                    ? view('guest.components.link', [
                            'name' => $publication->parent['title'],
                            'href' => route('guest.portfolio.publication.show', $publication->parent->slug)
                        ])
                    : ''
            ])
        @endif

        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $publication->featured
        ])

        @include('guest.components.show-row', [
            'name'  => 'summary',
            'value' => $publication->summary
        ])

        @include('guest.components.show-row', [
            'name'  => 'publication name',
            'value' => $publication->publication_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'publisher',
            'value' => $publication->publisher
        ])

        @include('guest.components.show-row', [
            'name'  => 'date',
            'value' => longDate($publication->date)
        ])

        @include('guest.components.show-row', [
            'name'  => 'year',
            'value' => $publication->year
        ])

        @include('guest.components.show-row', [
            'name'  => 'credit',
            'value' => $publication->credit
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'freelance',
            'checked' => $publication->freelance
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'fiction',
            'checked' => $publication->fiction
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'nonfiction',
            'checked' => $publication->nonfiction
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'technical',
            'checked' => $publication->technical
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'research',
            'checked' => $publication->research
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'poetry',
            'checked' => $publication->poetry
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'online',
            'checked' => $publication->online
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'novel',
            'checked' => $publication->novel
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'book',
            'checked' => $publication->book
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'textbook',
            'checked' => $publication->textbook
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'story',
            'checked' => $publication->story
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'article',
            'checked' => $publication->article
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'paper',
            'checked' => $publication->paper
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'pamphlet',
            'checked' => $publication->pamphlet
        ])

        @include('guest.components.show-row', [
            'name'  => 'publication url',
            'value' => $publication->publication_url,
        ])

        @if(!empty($publication->link))
            @include('guest.components.show-row-link', [
                'name'   => $publication->link_name,
                'href'   => $publication->link,
                'target' => '_blank'
            ])
        @endif

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($publication->description ?? '')
        ])

    </div>

@endsection
