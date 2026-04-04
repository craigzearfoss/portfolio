@php
    use App\Enums\PermissionEntityTypes;use App\Models\Career\Reference;

    $title    = $pageTitle ?? 'References';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->is_root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'References' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Reference::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Reference', 'href' => route('admin.career.reference.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-reference', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $references->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if(!empty($admin->is_root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>relation</th>
                        <th>phone</th>
                        <th>email</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if(!empty($admin->is_root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>relation</th>
                        <th>phone</th>
                        <th>email</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($references as $reference)

                    <tr data-id="{{ $reference->id }}">
                        @if($admin->is_root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $reference->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $reference->name !!}
                        </td>
                        <td data-field="relation">
                            {!! $reference->relation !!}
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $reference->phone !!}
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $reference->email !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $reference->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $reference->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($reference, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.reference.show', $reference),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($reference, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.reference.edit', $reference),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($reference->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($reference->link_name) ? $reference->link_name : 'link',
                                        'href'   => $reference->link,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if(canDelete($reference, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.career.reference.destroy', $reference) !!}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $admin->is_root ? '8' : '7' }}">No references found..</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $references->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
