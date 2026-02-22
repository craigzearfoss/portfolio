@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Database: ' . $adminDatabase->name . ' db for ' . $adminDatabase->owner->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (isRootAdmin() && !empty($owner)) {
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Databases', 'href' => route('admin.system.admin-database.index', [ 'owner_id'=>$owner->id ]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Databases', 'href' => route('admin.system.admin-database.index') ];
    }
    $breadcrumbs[] = [ 'name' => $adminDatabase->name . ' db' ];

    // set navigation buttons
    $navButtons = [];
    if (isRootAdmin() && !empty($owner)) {
        if (canUpdate(PermissionEntityTypes::RESOURCE, $adminDatabase, $admin)) {
            $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-database.edit', [ $adminDatabase, 'owner_id'=>$owner->id ]) ])->render();
        }
    } else {
        if (canUpdate(PermissionEntityTypes::RESOURCE, $adminDatabase, $admin)) {
            $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-database.edit', $adminDatabase) ])->render();
        }
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-database.index', (isRootAdmin() && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : []) ])->render();
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
                'value' => $adminDatabase->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $adminDatabase->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $adminDatabase->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'database',
                'value' => $adminDatabase->database
            ])

            @include('admin.components.show-row', [
                'name'  => 'tag',
                'value' => $adminDatabase->tag
            ])

            @include('admin.components.show-row', [
                'name'  => 'title',
                'value' => $adminDatabase->title
            ])

            @include('admin.components.show-row', [
                'name'  => 'plural',
                'value' => $adminDatabase->plural
            ])

            @include('admin.components.show-row-icon', [
                'name' => 'icon',
                'icon' => $adminDatabase->icon
            ])

            @include('admin.components.show-row-environments', [
                'resource' => $adminDatabase,
            ])

            @include('admin.components.show-row-menu-fields', [
                'menu'       => $adminDatabase->menu,
                'menu_level' => $adminDatabase->menu_level,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $adminDatabase,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($adminDatabase->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($adminDatabase->updated_at)
            ])

        </div>
    </div>

@endsection
