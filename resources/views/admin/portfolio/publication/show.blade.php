@php
    use App\Enums\PermissionEntityTypes;

    $title   = $pageTitle ?? 'Publication: ' . $publication->title;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',       'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,   'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',    'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Publications', 'href' => route('admin.portfolio.publication.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',    'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Publications', 'href' => route('admin.portfolio.publication.index') ];
    }
    $breadcrumbs[] = [ 'name' => $publication->name ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($publication, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.publication.edit', $publication)])->render();
    }
    if (canCreate($publication, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Publication', 'href' => route('admin.portfolio.publication.create', $owner ?? $admin)])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.publication.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'title',
                'value' => $publication->title
            ])

            @if(!empty($publication->parent))
                @include('admin.components.show-row', [
                    'name'  => 'parent',
                    'value' => view('admin.components.link', [
                                   'name' => $publication->parent->title ?? '',
                                   'href' => route('admin.portfolio.publication.show', $publication->parent->slug)
                               ])
                ])
            @endif

            @include('admin.components.show-row-checkmark', [
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
                'value' => longDate($publication->publication_date)
            ])

            @include('admin.components.show-row', [
                'name'  => 'year',
                'value' => $publication->publication_year
            ])

            @include('admin.components.show-row', [
                'name'  => 'credit',
                'value' => $publication->credit
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'freelance',
                'checked' => $publication->freelance
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'fiction',
                'checked' => $publication->fiction
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'nonfiction',
                'checked' => $publication->nonfiction
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'technical',
                'checked' => $publication->technical
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'research',
                'checked' => $publication->research
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'poetry',
                'checked' => $publication->poetry
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'online',
                'checked' => $publication->online
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'novel',
                'checked' => $publication->novel
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'book',
                'checked' => $publication->book
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'textbook',
                'checked' => $publication->textbook
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'article',
                'checked' => $publication->article
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'paper',
                'checked' => $publication->paper
            ])

            @include('admin.components.show-row-checkmark', [
                'name'    => 'pamphlet',
                'checked' => $publication->pamphlet
            ])

            @include('admin.components.show-row', [
                'name'  => 'publication url',
                'value' => $publication->publication_url,
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $publication->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $publication->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $publication->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $publication->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $publication->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $publication,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $publication,
            ])

        </div>

@endsection
