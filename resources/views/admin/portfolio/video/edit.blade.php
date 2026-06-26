@php
    use App\Models\Portfolio\Video;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $video       = $video ?? null;

    $title    = 'Edit ' . getResourcePageTitle($video);
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
    $breadcrumbs[] = [ 'name' => 'Videos',                            'href' => route('admin.portfolio.video.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($video, false), 'href' => route('admin.portfolio.video.show', $video) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.video.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.video.update', array_merge([$video], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.video.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $video->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $video->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $publication->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $video ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $video->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $video->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'parent_id',
                    'label'   => 'parent',
                    'value'   => old('parent_id') ?? $video->parent_id,
                    'list'    => new Video()->listOptions([ 'id <>' => $video->id ], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $video->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $video->summary,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-summary' ]
                ])

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4">

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'full_episode',
                                    'label'           => 'full episode',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('full_episode') ?? $video->full_episode,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'clip',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('clip') ?? $video->clip,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'public_access',
                                    'label'           => 'public access',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('public_access') ?? $video->is_public_access,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'source_recording',
                                    'label'           => 'source recording',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('source_recording') ?? $video->source_recording,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'date',
                    'name'      => 'video_date',
                    'label'     => 'video_date',
                    'value'     => old('video_date') ?? $video->video_date,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'video_year',
                    'label'     => 'year',
                    'value'     => old('video_year') ?? $video->video_year,
                    'min'       => 1950,
                    'max'       => date('Y'),
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'company',
                    'value'     => old('company') ?? $video->company,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'credit',
                    'value'   => old('credit') ?? $video->credit,
                    'message' => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'show',
                    'value'     => old('show') ?? $video->show,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'location',
                    'value'     => old('location') ?? $video->location,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

            </div>

        </div>
        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'embed',
                    'value'   => old('embed') ?? $video->embed,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'video_url',
                    'label'     => 'video url',
                    'value'     => old('video_url') ?? $video->video_url,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? $video->link,
                    'name'    => old('link_name') ?? $video->link_name,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $video->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $video->disclaimer,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-disclaimer' ]
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $video,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $video->notes,
                    'message' => $message ?? '',
                    'class'     => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $video->is_public,
                    'is_readonly' => old('is_readonly') ?? $video->is_readonly,
                    'is_root'     => old('is_root')     ?? $video->root,
                    'is_disabled' => old('is_disabled') ?? $video->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $video->is_demo,
                    'sequence'    => old('sequence')    ?? $video->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.video.index')
        ])

    </form>

@endsection
