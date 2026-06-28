@php
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $publication = $publication ?? null;

    $title    = 'Edit ' . getResourcePageTitle($publication);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                                 'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                      'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                              'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                               'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Publications',                            'href' => route('admin.portfolio.publication.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($publication, false), 'href' => route('admin.portfolio.publication.show', $publication) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.publication.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.publication.update', array_merge([$publication], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.publication.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $publication->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $publication->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $publication->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $publication->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'title',
                    'value'     => old('title') ?? $publication->title,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'parent_id',
                    'label'   => 'parent',
                    'value'   => old('parent_id') ?? $publication->parent_id,
                    'list'    => new Publication()->listOptions([ 'id <>' => $publication->id ], 'id', 'title', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $publication->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $publication->summary,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 5,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-summary' ],
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'publication_name',
                    'label'     => 'publication name',
                    'value'     => old('publication_name') ?? $publication->publication_name,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'publisher',
                    'value'     => old('publisher') ?? $publication->publisher,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'date',
                    'name'      => 'date',
                    'value'     => old('publication_date') ?? $publication->publication_date,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'year',
                    'value'     => old('publication_year') ?? $publication->publication_year,
                    'min'       => 1980,
                    'max'       => now("Y"),
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'credit',
                    'value'     => old('credit') ?? $publication->credit,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'freelance',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('freelance') ?? $publication->freelance,
                    'message'         => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4">

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'fiction',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('fiction') ?? $publication->fiction,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'nonfiction',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('nonfiction') ?? $publication->nonfiction,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'technical',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('technical') ?? $publication->technical,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'research',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('research') ?? $publication->research,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'poetry',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('poetry') ?? $publication->poetry,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4">

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'online',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('online') ?? $publication->online,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'novel',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('novel') ?? $publication->novel,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'book',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('book') ?? $publication->book,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'label'           => 'textbook',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('textbook') ?? $publication->summary,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'label'           => 'article',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('article') ?? $publication->article,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'label'           => 'pamphlet',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('pamphlet') ?? $publication->pamphlet,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'publication_url',
                    'label'     => 'publication url',
                    'value'     => old('publication_url') ?? $publication->publication_url,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $publication->link,
                    'name'    => old('link_name') ?? $publication->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $publication->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $publication->disclaimer,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 3,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-disclaimer' ],
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $publication,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $publication->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $publication->is_public,
                    'is_readonly' => old('is_readonly') ?? $publication->is_readonly,
                    'is_root'     => old('is_root')     ?? $publication->is_root,
                    'is_disabled' => old('is_disabled') ?? $publication->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $publication->is_demo,
                    'sequence'    => old('sequence')    ?? $publication->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.publication.index')
        ])

    </form>

@endsection
