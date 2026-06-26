@php
    use App\Models\Portfolio\Audio;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $audio       = $audio ?? null;

    $title    = 'Edit ' . getResourcePageTitle($audio);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                          'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                               'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                        'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                         'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Audio',                             'href' => route('admin.portfolio.audio.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($audio, false), 'href' => route('admin.portfolio.audio.show', $audio) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.audio.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.audio.update', array_merge([$audio], request()->all())) }}"
          class="admin-form"
          method="POST">
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.audio.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $audio->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $audio->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $audio->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $audio->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $audio->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-select-horizontal', [
                    'name'    => 'parent_id',
                    'label'   => 'parent',
                    'value'   => old('parent_id') ?? $audio->parent_id,
                    'list'    => new Audio()->listOptions([ 'id <>' => $audio->id ], 'id', 'name', true),
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $audio->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $audio->summary,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-summary' ]
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
                                    'name'            => 'full_episode',
                                    'label'           => 'full episode',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('full_episode') ?? $audio->full_episode,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'clip',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('clip') ?? $audio->clip,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'podcast',
                                    'label'           => 'podcast',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('podcast') ?? $audio->podcast,
                                    'message'         => $message ?? '',
                                ])

                                @include('admin.components.form-checkbox', [
                                    'name'            => 'source_recording',
                                    'label'           => 'source recording',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('source_recording') ?? $audio->source_recording,
                                    'message'         => $message ?? '',
                                ])

                            </div>

                        </div>
                    </div>
                </div>

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'date',
                    'name'      => 'audio_date',
                    'label'     => 'date',
                    'value'     => old('audio_date') ?? $audio->audio_date,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'audio_year',
                    'label'     => 'year',
                    'value'     => old('audio_year') ?? $audio->audio_year,
                    'min'       => 1950,
                    'max'       => date('Y'),
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'company',
                    'value'     => old('company') ?? $audio->company,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'    => 'credit',
                    'value'   => old('credit') ?? $audio->credit,
                    'message' => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'show',
                    'value'     => old('show') ?? $audio->show,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'location',
                    'value'     => old('location') ?? $audio->location,
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
                    'value'   => old('embed') ?? $audio->embed,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'audio_url',
                    'label'     => 'audio url',
                    'value'     => old('audio_url') ?? $audio->audio_url,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link' => old('link') ?? $audio->link,
                    'name' => old('link_name') ?? $audio->link_name,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $audio->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $audio->disclaimer,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-disclaimer' ]
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $audio,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $audio->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $audio->is_public,
                    'is_readonly' => old('is_readonly') ?? $audio->is_readonly,
                    'is_root'     => old('is_root')     ?? $audio->root,
                    'is_disabled' => old('is_disabled') ?? $audio->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $audio->is_demo,
                    'sequence'    => old('sequence')    ?? $audio->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.audio.index')
        ])

    </form>

@endsection
