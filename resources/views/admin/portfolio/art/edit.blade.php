@php
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $art         = $art ?? null;

    $title    = 'Edit ' . getResourcePageTitle($art);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                         'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                              'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                      'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                       'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Art',                             'href' => route('admin.portfolio.art.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($art, false), 'href' => route('admin.portfolio.art.show', $art) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.art.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.art.update', array_merge([$art], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.art.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $art->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $art->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $art->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $art->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $art->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'artist',
                    'value'     => old('artist') ?? $art->artist,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $art->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $art->summary,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 5,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-summary' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'art_year',
                    'label'     => 'year',
                    'value'     => old('art_year') ?? $art->art_year,
                    'min'       => -2000,
                    'max'       => date("Y"),
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $art->link,
                    'name'    => old('link_name') ?? $art->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $art->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $art->disclaimer,
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 3,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-disclaimer' ],
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $art,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $art->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $art->is_public,
                    'is_readonly' => old('is_readonly') ?? $art->is_readonly,
                    'is_root'     => old('is_root')     ?? $art->root,
                    'is_disabled' => old('is_disabled') ?? $art->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $art->is_demo,
                    'sequence'    => old('sequence')    ?? $art->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.art.index')
        ])

    </form>

@endsection
