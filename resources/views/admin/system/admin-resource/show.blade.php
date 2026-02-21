@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Resource: ' . $adminResource->database->name . '.' . $adminResource->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                 'href' => route('admin.dashboard') ],
    ];
    if (isRootAdmin() && !empty($owner)) {
        $breadcrumbs[] = [ 'name' => $owner->name,                           'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Databases',                            'href' => route('admin.system.admin-database.index', [ 'owner_id'=>$owner->id ]) ];
        $breadcrumbs[] = [ 'name' => $adminResource->database->name . ' db', 'href' => route('admin.system.admin-database.show', [ $adminResource->database, 'owner_id'=>$owner ]) ];
        $breadcrumbs[] = [ 'name' => 'Resources',                            'href' => route('admin.system.admin-resource.index', [ 'owner_id'=>$owner->id ]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Databases',  'href' => route('admin.system.admin-database.index') ];
        $breadcrumbs[] = [ 'name' => 'Resources',  'href' => route('admin.system.admin-resource.index') ];
    }
    $breadcrumbs[] = [ 'name' => $adminResource->name . ' db' ];

    // set navigation buttons
    $buttons = [];
    if (isRootAdmin() && !empty($owner)) {
        if (canUpdate(PermissionEntityTypes::RESOURCE, $adminResource, $admin)) {
            $buttons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-resource.edit', [ $adminResource, 'owner_id'=>$owner->id ]) ])->render();
        }
    } else {
        if (canUpdate(PermissionEntityTypes::RESOURCE, $adminResource, $admin)) {
            $buttons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-resource.edit', $adminResource) ])->render();
        }
    }
    $buttons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-resource.index', (isRootAdmin() && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : []) ])->render();
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
                'value' => $adminResource->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $adminResource->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'database',
                'value' => $adminResource->database->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $adminResource->name
            ])

            @if(!empty($adminResource->parent))
                @include('admin.components.show-row-link', [
                    'name'   => 'parent',
                    'label'  => $adminResource->parent->name,
                    'href'   => route('admin.system.resource.show', $adminResource->parent->id)
                ])
            @else
                @include('admin.components.show-row', [
                    'name'  => 'parent',
                    'value' => ''
                ])
            @endif

            <div class="columns">
                <div class="column is-2"><strong>children</strong>:</div>
                <div class="column is-10 pl-0">
                    @if(!empty($adminResource->children))
                        <ol>
                            @foreach($adminResource->children as $child)
                                <li>
                                    @include('admin.components.link', [
                                        'name' => $child->name,
                                        'href' => route('admin.system.resource.show', $child)
                                    ])
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>

            @include('admin.components.show-row', [
                'name'  => 'table',
                'value' => $adminResource->table
            ])

            @include('admin.components.show-row', [
                'name'  => 'class',
                'value' => $adminResource->class
            ])

            @include('admin.components.show-row', [
                'name'  => 'title',
                'value' => $adminResource->title
            ])

            @include('admin.components.show-row', [
                'name'  => 'plural',
                'value' => $adminResource->plural
            ])

            @include('admin.components.show-row-icon', [
                'name' => 'icon',
                'icon' => $adminResource->icon
            ])

            @include('admin.components.show-row-environments', [
                'resource' => $adminResource,
            ])

            @include('admin.components.show-row-menu-fields', [
                'menu'       => $adminResource->menu,
                'menu_level' => $adminResource->menu_level,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $adminResource,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($adminResource->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($adminResource->updated_at)
            ])

        </div>
    </div>

@endsection
