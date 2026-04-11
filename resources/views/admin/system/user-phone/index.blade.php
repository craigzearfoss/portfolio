@php
    use App\Models\System\AdminEmail;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? ($isRootAdmin ? 'User Phone Numbers' : 'Phone Numbers');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Phone Numbers' : 'Phone Numbers' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(AdminEmail::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add Phone Number',
                                                               'href' => route('admin.system.user-phone.create',
                                                                               $user ? [ 'user_id' => $user->id ] : []
                                                                              )
                                                             ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.system-user')
    @endif

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $userPhones->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>user</th>
                        @endif
                        <th>email</th>
                        <th>label</th>
                        <th class="has-text-centered">public</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                    @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
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

                @forelse ($userPhones as $userPhone)

                    <tr data-id="{{ $userPhone->id }}">
                        @if($isRootAdmin)
                            <td data-field="user.username" style="white-space: nowrap;">
                                @if(!empty($userPhone->user))
                                    @include('admin.components.link', [
                                        'name' => $userPhone->user->username,
                                        'href' => route('admin.system.user.show', $userPhone->user)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="phone">
                            {!! $userPhone->phone !!}
                        </td>
                        <td data-field="label">
                            {!! $userPhone->label !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userPhone->is_public ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($userPhone, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-phone.show', $userPhone),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($userPhone, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.user-phone.edit', $userPhone),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete($userPhone, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.system.user-phone.destroy', $userPhone) !!}"
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
                        @if($isRootAdmin)
                            <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No user phone numbers found.</td>
                        @else
                            <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No phone numbers found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $userPhones->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
