@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $project     = $project ?? null;

    $title    = 'Edit ' . getResourcePageTitle($project);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                             'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                  'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                          'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                           'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Projects',                            'href' => route('admin.portfolio.project.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($project, false), 'href' => route('admin.portfolio.project.show', $project) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.project.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.project.update', array_merge([$project], request()->all())) }}"
          class="admin-form"
          method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.project.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $project->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $project->id,
                    'hide'  => !$isRootAdmin,
                ])

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? $project->owner_id,
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $project->owner_id
                    ])
                @endif

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $project->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $project->featured,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $project->summary,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-summary' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'project_year',
                    'label'     => 'year',
                    'value'     => old('project_year') ?? $project->project_year,
                    'min'       => 1980,
                    'max'       => 2050,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'language',
                    'value'     => old('language') ?? $project->language,
                    'maxlength' => 50,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'language_version',
                    'value'     => old('language_version') ?? $project->language_version,
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'repository_url',
                    'value'     => old('repository_url') ?? $project->repository_url,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'repository_name',
                    'value'     => old('repository_name') ?? $project->repository_name,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-link-horizontal', [
                    'link' => old('link') ?? $project->link,
                    'name' => old('link_name') ?? $project->link_name,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $project->description,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? $project->disclaimer,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-disclaimer' ]
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $project,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $project->notes,
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $project->is_public,
                    'is_readonly' => old('is_readonly') ?? $project->is_readonly,
                    'is_root'     => old('is_root')     ?? $project->root,
                    'is_disabled' => old('is_disabled') ?? $project->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $project->is_demo,
                    'sequence'    => old('sequence')    ?? $project->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.project.index')
        ])

    </form>

@endsection
