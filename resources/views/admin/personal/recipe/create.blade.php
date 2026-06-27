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
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Recipes',    'href' => route('admin.personal.recipe.index') ];
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.personal.recipe.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <form action="{{ route('admin.personal.recipe.store', request()->all()) }}"
          class="admin-form"
          method="POST"
    >
        @csrf

        @include('admin.components.form-hidden', [
            'name'  => 'referer',
            'value' => referer('admin.personal.recipe.index')
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

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'name',
                    'value'     => old('name') ?? '',
                    'required'  => true,
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-checkbox-horizontal', [
                    'name'            => 'featured',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('featured') ?? 0,
                    'message'         => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'summary',
                    'value'     => old('summary') ?? '',
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 5,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-summary' ],
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'source',
                    'value'     => old('source') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
                ])

                @include('admin.components.form-input-horizontal', [
                    'name'      => 'author',
                    'value'     => old('author') ?? '',
                    'maxlength' => 255,
                    'message'   => $message ?? '',
                    'class'     => [ 'input-name' ]
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

            </div>

        </div>

        <div class="floating-div-container">

            <div class="floating-div card admin-form-card">

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                    </div>
                    <div class="field-body">
                        <div class="field">

                            <div class="checkbox-container card form-container p-4" style="width: 44rem;">

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'main',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('main') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'side',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('side') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'dessert',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('dessert') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'appetizer',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('appetizer') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'beverage',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('beverage') ?? 0,
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

                            <div class="checkbox-container card form-container p-4" style="width: 36rem;">

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'breakfast',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('breakfast') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'lunch',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('lunch') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'dinner',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('dinner') ?? 0,
                                    'message'         => $message ?? '',
                                ])

                                @include('guest.components.form-checkbox', [
                                    'name'            => 'snack',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('snack') ?? 0,
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

                @include('admin.components.form-link-horizontal', [
                    'link'    => old('link') ?? '',
                    'name'    => old('link_name') ?? '',
                    'message' => $message ?? '',
                ])

                @include('admin.components.form-textarea-horizontal', [
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

                @include('admin.components.form-textarea-horizontal', [
                    'name'      => 'disclaimer',
                    'value'     => old('disclaimer') ?? '',
                    'maxlength' => 500,
                    'cols'      => 30,
                    'rows'      => 3,
                    'message'   => $message ?? '',
                    'class'     => [ 'textarea-disclaimer' ],
                ])

                @include('admin.components.form-textarea-horizontal', [
                    'name'    => 'notes',
                    'value'   => old('notes') ?? '',
                    'message' => $message ?? '',
                    'class'   => [ 'textarea-notes' ]
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
            'label'      => 'Add Recipe',
            'cancel_url' => referer('admin.personal.recipe.index')
        ])

    </form>

@endsection
