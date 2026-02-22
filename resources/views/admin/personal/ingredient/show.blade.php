@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Ingredient: ' . $ingredient->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.ingredient.index') ],
        [ 'name' => $ingredient->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $ingredient, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.ingredient.edit', $ingredient)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'ingredient', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Ingredient', 'href' => route('admin.personal.ingredient.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.ingredient.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $ingredient->id
            ])

            @include('admin.components.show-row', [
                'name'  => 'full_name',
                'value' => $ingredient->full_name
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $ingredient->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $ingredient->slug
            ])

            @include('admin.components.show-row-link', [
                'name'   => $ingredient->link_name ?? 'link',
                'href'   => $ingredient->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $ingredient->description
            ])

            @include('admin.components.show-row-images', [
                'resource' => $ingredient,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $ingredient,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($ingredient->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($ingredient->updated_at)
            ])

        </div>
    </div>

@endsection
