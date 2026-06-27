@php
    use App\Models\Personal\Recipe;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $recipeStep  = $recipeStep ?? null;

    $title    = $pageTitle ?? 'Add New Recipe Step';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ]
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Recipes',    'href' => route('admin.personal.recipe.index') ];
    $breadcrumbs[] = [ 'name' => 'Steps',      'href' => route('admin.personal.recipe-step.index') ];
    $breadcrumbs[] = [ 'name' => 'Add Step' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.personal.recipe-step.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.personal.recipe-step.store', request()->all()) }}"
          class="admin-form"
          method="POST"
    >
        @csrf

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.personal.recipe-step.index')
        ])

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @if ($isRootAdmin)
                    @include('admin.components.favorites-box-form-input', [
                        'name'  => 'favorite_count',
                        'label' => 'favorites',
                        'value' => old('favorite_count') ?? 0,
                    ])
                @endif

                @if ($isRootAdmin)
                    @include('admin.components.form-select-horizontal', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => old('owner_id') ?? '',
                        'required' => true,
                        'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'message'  => $message ?? '',
                        'class'    => [ 'select-owner' ]
                    ])
                @else
                    @include('admin.components.form-hidden', [
                        'name'  => 'owner_id',
                        'value' => $admin->id ?? null,
                    ])
                @endif

                @include('admin.components.form-select-horizontal', [
                    'name'     => 'recipe_id',
                    'label'    => 'recipe',
                    'value'    => old('recipe_id') ?? '',
                    'required' => true,
                    'list'     => new Recipe()->listOptions([], 'id', 'name', true),
                    'message'  => $message ?? '',
                ])

                @include('admin.components.form-input-horizontal', [
                    'type'      => 'number',
                    'name'      => 'step',
                    'value'     => old('step') ?? 1,
                    'required'  => true,
                    'min'       => 1,
                    'message'   => $message ?? '',
                    'style'     => [ 'width: 4rem' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('guest.components.form-textarea-horizontal', [
                    'name'    => 'description',
                    'id'      => 'inputEditor',
                    'value'   => old('description') ?? '',
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-description' ]
                ])

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                @include('guest.components.show-row-images', [
                    'resource' => $recipeStep,
                    'upload'   => false,
                    'download' => true,
                    'external' => true,
                    'editPage' => true,
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

            </div>

        </div>

        @include('admin.components.form-button-submit-horizontal', [
            'label'      => 'Save',
            'cancel_url' => referer('admin.personal.recipe-step.index')
        ])

    </form>

@endsection
