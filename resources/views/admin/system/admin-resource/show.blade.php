@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Resource: ' . $adminResource->database->name . '.' . $adminResource->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',                          'href' => route('admin.system.index',
                                                                       !empty($owner)
                                                                           ? ['owner_id'=>$owner->id]
                                                                           : []
                                                                      )],
    ];

    if ($isRootAdmin || ($owner->id == $adminResource->owner_id)) {
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
    $navButtons = [];
    if ($isRootAdmin || ($owner->id == $adminResource->owner_id)) {
        if (canUpdate($adminResource, $admin)) {
            $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-resource.edit', [ $adminResource, 'owner_id'=>$owner->id ]) ])->render();
        }
    } else {
        if (canUpdate($adminResource, $admin)) {
            $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin-resource.edit', $adminResource) ])->render();
        }
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.admin-resource.index', ($isRootAdmin && !empty($owner)) ? [ 'owner_id'=>$owner->id ] : []) ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $adminResource->id
            ])

            @if($isRootAdmin)
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
                'name'  => $isRootAdmin ? 'resource name' : 'resource',
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
                    'value' => '<i>None</i>'
                ])
            @endif
@php dd($adminResource->children); @endphp
            @if(!empty($adminResource->children()))
                <div class="columns">
                    <div class="column is-2"><strong>children</strong>:</div>
                    <div class="column is-10 pl-0">
                        <ol>
                            @foreach($adminResource->children() as $child)
                                <li>
                                    @include('admin.components.link', [
                                        'name' => $child->name,
                                        'href' => route('admin.system.resource.show', $child)
                                    ])
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            @else
                @include('admin.components.show-row', [
                    'name'  => 'children',
                    'value' => '<i>None</i>'
                ])
            @endif

            @if($isRootAdmin)

                @include('admin.components.show-row', [
                    'name'  => 'table',
                    'value' => $adminResource->table_name
                ])

                @include('admin.components.show-row', [
                    'name'  => 'class',
                    'value' => $adminResource->class
                ])

            @endif

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

            @include('admin.components.show-row-checkbox', [
                'name'    => 'has owner',
                'checked' => $adminResource->has_owner,
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
