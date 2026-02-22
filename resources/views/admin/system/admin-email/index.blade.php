@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? (isRootAdmin() ? 'Admin Emails' : 'Emails');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => isRootAdmin() ? 'Admin Emails' : 'Emails' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'admin-email', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add Email',
                                                               'href' => route('admin.system.admin-email.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.system.admin-email.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $adminEmails->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>email</th>
                    <th>label</th>
                    <th class="has-text-centered">public</th>
                    <th>actions</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->root))
                            <th>owner</th>
                        @endif
                        <th>email</th>
                        <th>label</th>
                        <th class="has-text-centered">public</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($adminEmails as $adminEmail)

                    <tr data-id="{{ $adminEmail->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if(!empty($adminEmail->owner))
                                    @include('admin.components.link', [
                                        'name' => $adminEmail->owner->username,
                                        'href' => route('admin.system.admin.show', $adminEmail->owner)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="email">
                            {!! $adminEmail->email !!}
                        </td>
                        <td data-field="label">
                            {!! $adminEmail->label !!}
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminEmail->public ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $adminEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-email.show', $adminEmail->id),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $adminEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-email.edit', $adminEmail->id),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $adminEmail, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.admin-email.destroy', $adminEmail) !!}" method="POST">
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
                        <td colspan="{{ $admin->root ? '5' : '4' }}">There are no emails.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $adminEmails->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
