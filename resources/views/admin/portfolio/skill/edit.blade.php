@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Skills',     'href' => route('admin.portfolio.skill.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $skill->name, 'href' => route('admin.portfolio.skill.show', [$skill, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Skills',     'href' => route('admin.portfolio.skill.index') ];
        $breadcrumbs[] = [ 'name' => $skill->name, 'href' => route('admin.portfolio.skill.show', $skill) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.skill.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Skill: ' . $skill->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.skill.update', array_merge([$skill], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.skill.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $skill->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $skill->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([],
                                                                        'id',
                                                                        'username',
                                                                        true,
                                                                        false,
                                                                        [ 'username', 'asc' ]
                                                                       ),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $skill->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $skill->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'version',
                'value'     => old('version') ?? $skill->version,
                'maxlength' => 20,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? $skill->featured,
                'message'         => $message ?? '',
            ])

            TYPE @TODO

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $skill->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'dictionary_category_id',
                'label'    => 'category',
                'value'    => old('dictionary_category_id') ?? $skill->dictionary_category_id,
                'required' => true,
                'list'     => \App\Models\Dictionary\Category::listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'level',
                'label'       => 'level (1 to 10)',
                'value'       => old('level') ?? $skill->level,
                'min'         => 1,
                'max'         => 10,
                'required'    => true,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'start_year',
                'label'     => 'start year',
                'value'     => old('start_year') ?? $skill->start_year,
                'min'       => 1980,
                'max'       => date("Y"),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'end_year',
                'label'     => 'end year',
                'value'     => old('end_year') ?? $skill->end_year,
                'min'       => 1980,
                'max'       => date("Y"),
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'years',
                'value'       => old('years') ?? $skill->years,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $skill->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $skill->link,
                'name' => old('link_name') ?? $skill->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $skill->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $skill->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $skill->image,
                'credit'  => old('image_credit') ?? $skill->image_credit,
                'source'  => old('image_source') ?? $skill->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $skill->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'      => old('public')   ?? $skill->public,
                'readonly'    => old('readonly') ?? $skill->readonly,
                'root'        => old('root')     ?? $skill->root,
                'disabled'    => old('disabled') ?? $skill->disabled,
                'demo'        => old('demo')     ?? $skill->demo,
                'sequence'    => old('sequence') ?? $skill->sequence,
                'message'     => $message ?? '',
                'isRootAdmin' => isRootAdmin(),
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.skill.index')
            ])

        </form>

    </div>

@endsection
