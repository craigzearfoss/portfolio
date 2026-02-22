@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Database: ' . $database->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Databases',       'href' => route('admin.system.database.index') ],
        [ 'name' => $database->name ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $database, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.database.edit', $database) ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.database.index') ])->render();
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
                'value' => $database->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $database->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $database->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'database',
                'value' => $database->database
            ])

            @include('admin.components.show-row', [
                'name'  => 'tag',
                'value' => $database->tag
            ])

            @include('admin.components.show-row', [
                'name'  => 'title',
                'value' => $database->title
            ])

            @include('admin.components.show-row', [
                'name'  => 'plural',
                'value' => $database->plural
            ])

            @include('admin.components.show-row-icon', [
                'name' => 'icon',
                'icon' => $database->icon
            ])

            @include('admin.components.show-row-environments', [
                'resource' => $database,
            ])

            @include('admin.components.show-row-menu-fields', [
                'menu'       => $database->menu,
                'menu_level' => $database->menu_level,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $database,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($database->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($database->updated_at)
            ])

        </div>
    </div>

@endsection
