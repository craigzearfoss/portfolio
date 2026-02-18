@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'References' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'reference', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Reference', 'href' => route('admin.career.reference.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'References',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.career.reference.index') ])
    @endif

    <div class="card p-4">

        @if($pagination_top)
            {!! $references->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table admin-table">
            <thead>
            <tr>
                @if(!empty($admin->root))
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

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
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
                    @if($admin->root)
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
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reference->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reference->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(PermissionEntityTypes::RESOURCE, $reference, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.reference.show', $reference),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(PermissionEntityTypes::RESOURCE, $reference, $admin))
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

                            @if(canDelete(PermissionEntityTypes::RESOURCE, $reference, $admin))
                                <form class="delete-resource" action="{!! route('admin.career.reference.destroy', $reference) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '8' : '7' }}">There are no references.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $references->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
