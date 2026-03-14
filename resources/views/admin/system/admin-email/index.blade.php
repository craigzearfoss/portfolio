@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\System\AdminEmail;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Admin Email Addresses' : 'Email Addresses');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index',
                                                       !empty($owner)
                                                           ? ['owner_id'=>$owner->id]
                                                           : []
                                                      )],
        [ 'name' => $isRootAdmin ? 'Admin Emails' : 'Emails' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(AdminEmail::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Email',
                                                               'href' => route('admin.system.admin-email.create',
                                                                               $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if($isRootAdmin)
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
                    @if($isRootAdmin)
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
                        @if($isRootAdmin)
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
                        @if($isRootAdmin)
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
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminEmail->is_public ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($adminEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-email.show', $adminEmail),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($adminEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-email.edit', $adminEmail),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete($adminEmail, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.system.admin-email.destroy', $adminEmail) !!}"
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
                        <td colspan="{{ $isRootAdmin ? '5' : '4' }}">There are no email addresses.</td>
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
