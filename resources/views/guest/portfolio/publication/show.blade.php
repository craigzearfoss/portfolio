@php
    $title = $pageTitle ?? 'Publication: ' . $publication->title;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',         'href' => route('guest.index') ],
        [ 'name' => 'Candidates',   'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name,   'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',    'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Publications', 'href' => route('guest.portfolio.publication.index', $owner) ],
        [ 'name' => $publication->title ],
    ];

    // set navigation buttons
    $navButtons = [
        view('guest.components.nav-button-back',  ['href' => referer('guest.admin.portfolio.publication.index', $owner)])->render(),
    ];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $publication->disclaimer ])

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'title',
            'value' => $publication->title
        ])

        @if(!empty($publication->parent))
            @include('guest.components.show-row', [
                'name'  => 'parent',
                'value' => view('guest.components.link', [
                                'name' => $publication->parent->title,
                                'href' => route('guest.portfolio.publication.show', $owner, $publication->parent->slug)
                          ])
            ])
        @endif

        <?php /*
        @include('guest.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $publication->featured
        ])
        */ ?>

        @if(!empty($publication->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $publication->summary
            ])
        @endif

        @if($publication->children->count() > 0)
            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    <ol>
                        @foreach($publication->children as $child)
                            <li>
                                @include('guest.components.link', [
                                    'name' => $child->name,
                                    'href' => route('guest.portfolio.publication.show', [$owner, $child->slug])
                                ])
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

        @if(empty($publication->publication_name))
            @include('guest.components.show-row', [
                'name'  => 'publication name',
                'value' => $publication->publication_name
            ])
        @endif

        @if(empty($publication->publisher))
            @include('guest.components.show-row', [
                'name'  => 'publisher',
                'value' => $publication->publisher
            ])
        @endif

        @if(empty($publication->date))
            @include('guest.components.show-row', [
                'name'  => 'date',
                'value' => longDate($publication->date)
            ])
        @endif

        @if(empty($publication->year))
            @include('guest.components.show-row', [
                'name'  => 'year',
                'value' => $publication->year
            ])
        @endif

        @if(empty($publication->credit))
            @include('guest.components.show-row', [
                'name'  => 'credit',
                'value' => $publication->credit
            ])
        @endif

        @if(!empty($publication->freelance))
        @include('guest.components.show-row-checkbox', [
            'name'    => 'freelance',
            'checked' => $publication->freelance
        ])
        @endif

        @if(!empty($publication->fiction))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'fiction',
                'checked' => $publication->fiction
            ])
        @endif

        @if(!empty($publication->nonfiction))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'nonfiction',
                'checked' => $publication->nonfiction
            ])
        @endif

        @if(!empty($publication->technical))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'technical',
                'checked' => $publication->technical
            ])
        @endif

        @if(!empty($publication->research))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'research',
                'checked' => $publication->research
            ])
        @endif

        @if(!empty($publication->poetry))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'poetry',
                'checked' => $publication->poetry
            ])
        @endif

        @if(!empty($publication->online))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'online',
                'checked' => $publication->online
            ])
        @endif

        @if(!empty($publication->novel))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'novel',
                'checked' => $publication->novel
            ])
        @endif

        @if(!empty($publication->book))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'book',
                'checked' => $publication->book
            ])
        @endif

        @if(!empty($publication->textbook))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'textbook',
                'checked' => $publication->textbook
            ])
        @endif

        @if(!empty($publication->story))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'story',
                'checked' => $publication->story
            ])
        @endif

        @if(!empty($publication->article))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'article',
                'checked' => $publication->article
            ])
        @endif

        @if(!empty($publication->paper))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'paper',
                'checked' => $publication->paper
            ])
        @endif

        @if(!empty($publication->pamphlet))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'pamphlet',
                'checked' => $publication->pamphlet
            ])
        @endif

        @if(!empty($publication->publication_url))
            @include('guest.components.show-row', [
                'name'  => 'publication url',
                'value' => $publication->publication_url,
            ])
        @endif

        @if(!empty($publication->link))
            @include('guest.components.show-row-link', [
                'name'   => !empty($publication->link_name) ? $publication->link_name : 'link',
                'href'   => $publication->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($publication->description ))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($publication->description)
            ])
        @endif

        @if(!empty($publication->image))
            @include('guest.components.show-row-image', [
                'name'         => 'image',
                'src'          => $publication->image,
                'alt'          => $publication->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($publication->name, $publication->image),
                'image_credit' => $publication->image_credit,
                'image_source' => $publication->image_source,
            ])
        @endif

        @if(!empty($publication->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $publication->thumbnail . ' thumbnail',
                'alt'      => $publication->name,
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($publication->name . '-thumbnail', $publication->thumbnail)
            ])
        @endif

    </div>

@endsection
