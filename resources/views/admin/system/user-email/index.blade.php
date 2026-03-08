@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\System\UserEmail;

    $title    = $pageTitle ?? ($isRootAdmin ? 'User Email Addresses' : 'Email Addresses');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Email Addresses' : 'Email Addresses' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(UserEmail::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Email',
                                                               'href' => route('admin.system.user-email.create',
                                                                               $user ? [ 'user_id' => $user->id ] : []
                                                                              )
                                                             ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.user', [ 'action' => route('admin.system.user-email.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $userEmails->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>user</th>
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
                            <th>user</th>
                        @endif
                        <th>email</th>
                        <th>label</th>
                        <th class="has-text-centered">public</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($userEmails as $userEmail)

                    <tr data-id="{{ $userEmail->id }}">
                        @if($isRootAdmin)
                            <td data-field="user.username" style="white-space: nowrap;">
                                @if(!empty($userEmail->user))
                                    @include('admin.components.link', [
                                        'name' => $userEmail->user->username,
                                        'href' => route('admin.system.user.show', $userEmail->user)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="email">
                            {!! $userEmail->email !!}
                        </td>
                        <td data-field="label">
                            {!! $userEmail->label !!}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userEmail->public ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($userEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-email.show', $userEmail),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($userEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.user-email.edit', $userEmail),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete($userEmail, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.system.user-email.destroy', $userEmail) !!}"
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
                        <td colspan="{{ $admin->root ? '5' : '4' }}">There are no email addresses.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $userEmails->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
