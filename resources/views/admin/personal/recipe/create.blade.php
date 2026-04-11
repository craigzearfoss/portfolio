@php
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $recipe      = $recipe ?? null;

    $title    = $pageTitle ?? 'Add New Recipe';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Recipes',    'href' => route('admin.personal.recipe.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
        $breadcrumbs[] = [ 'name' => 'Recipes',    'href' => route('admin.personal.recipe.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.personal.recipe.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.personal.recipe.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.personal.recipe.index')
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => Auth::guard('admin')->user()->id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? 1,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'source',
                'value'     => old('source') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'author',
                'value'     => old('author') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'prep_time',
                'label'     => 'prep time (minutes)',
                'value'     => old('prep_time') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'number',
                'name'      => 'total_time',
                'label'     => 'total time (minutes)',
                'value'     => old('total_time') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'main',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('main') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'side',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('side') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'dessert',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('dessert') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'appetizer',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('appetizer') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'beverage',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('beverage') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'breakfast',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('breakfast') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'lunch',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('lunch') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'dinner',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('dinner') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'snack',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('snack') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? '',
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? 0,
                'is_readonly' => old('is_readonly') ?? 0,
                'is_root'     => old('is_root')     ?? 0,
                'is_disabled' => old('is_disabled') ?? 0,
                'is_demo'     => old('is_demo')     ?? 0,
                'sequence'    => old('sequence')    ?? 0,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Recipe',
                'cancel_url' => referer('admin.personal.recipe.index')
            ])

        </form>

    </div>

@endsection
