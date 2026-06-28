@php
    use App\Models\Portfolio\Music;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $music       = $music ?? null;

    $title    = 'Edit ' . getResourcePageTitle($music);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                           'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                        'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                         'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Music',                             'href' => route('admin.portfolio.music.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($music, false), 'href' => route('admin.portfolio.music.show', $music) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.music.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.music.update', array_merge([$music], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.music.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $music->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $music->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $music->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $music->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $music->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'artist',
                    'value'     => old('artist') ?? $music->artist,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'parent_id',
                    'label'   => 'parent',
                    'value'   => old('parent_id') ?? $music->parent_id,
                    'list'    => new Music()->listOptions([ 'id <>' => $music->id ], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $music->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $music->summary,
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

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'collection',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('collection') ?? $music->collection,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'track',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('track') ?? $music->track,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'label',
                    'value'     => old('label') ?? $music->label,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'catalog_number',
                    'label'     => 'catalog number',
                    'value'     => old('catalog_number') ?? $music->catalog_number,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'music_year',
                    'label'     => 'year',
                    'value'     => old('music_year') ?? '',
                    'min'       => 1900,
                    'max'       => 2050,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'date',
                    'name'      => 'release_date',
                    'label'     => 'release date',
                    'value'     => old('release_date') ?? $music->release_date,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'embed',
                    'value'   => old('embed') ?? $music->embed,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'audio_url',
                    'label'     => 'audio url',
                    'value'     => old('audio_url') ?? $music->audio_url,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $music->link,
                    'name'    => old('link_name') ?? $music->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $music->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $music->disclaimer,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 3,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-disclaimer' ],
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $music,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $music->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $music->is_public,
                    'is_readonly' => old('is_readonly') ?? $music->is_readonly,
                    'is_root'     => old('is_root')     ?? $music->root,
                    'is_disabled' => old('is_disabled') ?? $music->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $music->is_demo,
                    'sequence'    => old('sequence')    ?? $music->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.music.index')
        ])

    </form>

@endsection
