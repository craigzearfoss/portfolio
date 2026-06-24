@php
    use App\Models\Dictionary\Category;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $antiSkill   = $antiSkill ?? null;

    $title    = 'Edit ' . getResourcePageTitle($antiSkill);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                               'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                    'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                            'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',                             'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Anti-Skills',                           'href' => route('admin.portfolio.anti-skill.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($antiSkill, false), 'href' => route('admin.portfolio.anti-skill.show', $antiSkill) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.portfolio.anti-skill.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.portfolio.anti-skill.update', array_merge([$antiSkill], request()->all())) }}"
          class="admin-form"
          method="POST">
        @csrf
        @method('PUT')

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.portfolio.anti-skill.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? $antiSkill->favorite_count,
                    ])
                @endif

                @include('admin.components.form-text-horizontal', [
                    'name'  => 'id',
                    'value' => $antiSkill->id,
                    'hide'  => !$isRootAdmin,
                ])

                <?php /* note that you CANNOT change the owner of a skill */ ?>
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $antiSkill->owner_id
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? $antiSkill->name,
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'version',
                    'value'     => old('version') ?? $antiSkill->version,
                    'maxlength' => 20,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? $antiSkill->featured,
                    'message'         => $message ?? '',
                ])

                TYPE @TODO

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? $antiSkill->summary,
                    'maxlength' => 500,
                    'message'   => $message ?? '',
                    'style'     => [ 'max-width: 40rem !important' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'dictionary_category_id',
                    'label'    => 'category',
                    'value'    => old('dictionary_category_id') ?? $antiSkill->dictionary_category_id,
                    'required' => true,
                    'list'     => new Category()->listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'number',
                    'name'        => 'level',
                    'label'       => 'level (1 to 10)',
                    'value'       => old('level') ?? $antiSkill->level,
                    'min'         => 1,
                    'max'         => 10,
                    'required'    => true,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'start_year',
                    'label'     => 'start year',
                    'value'     => old('start_year') ?? $antiSkill->start_year,
                    'min'       => 1980,
                    'max'       => date("Y"),
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'end_year',
                    'label'     => 'end year',
                    'value'     => old('end_year') ?? $antiSkill->end_year,
                    'min'       => 1980,
                    'max'       => date("Y"),
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'        => 'number',
                    'name'        => 'years',
                    'value'       => old('years') ?? $antiSkill->years,
                    'min'         => 0,
                    'message'     => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-link-horizontal', [
                    'link' => old('link') ?? $antiSkill->link,
                    'name' => old('link_name') ?? $antiSkill->link_name,
                    'message'   => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? $antiSkill->description,
                    'message' => $message ?? '',
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('admin.components.form-input-horizontal', [
                    'name'        => 'disclaimer',
                    'value'       => old('disclaimer') ?? $antiSkill->disclaimer,
                    'maxlength'   => 500,
                    'message'     => $message ?? '',
                ])

                @include('admin.components.show-row-images', [
                    'resource' => $antiSkill,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? $antiSkill->notes,
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-visibility-horizontal', [
                    'is_public'   => old('is_public')   ?? $antiSkill->is_public,
                    'is_readonly' => old('is_readonly') ?? $antiSkill->is_readonly,
                    'is_root'     => old('is_root')     ?? $antiSkill->root,
                    'is_disabled' => old('is_disabled') ?? $antiSkill->is_disabled,
                    'is_demo'     => old('is_demo')     ?? $antiSkill->is_demo,
                    'sequence'    => old('sequence')    ?? $antiSkill->sequence,
                    'message'     => $message           ?? '',
                ])

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.portfolio.anti-skill.index')
        ])

    </form>

@endsection
