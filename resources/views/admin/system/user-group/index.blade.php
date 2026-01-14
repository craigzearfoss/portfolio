@php
$buttons = [];
if (canCreate('user-group', getAdminId())) {
    $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Add New User Group', 'href' => route('root.user-group.create') ];
}
if (canRead('user-team', getAdminId())) {
    $buttons[] = [ 'name' => '<i class="fa fa-list"></i> User Teams', 'href' => route('root.user-team.index') ];
}
@endphp
@extends('admin.layouts.default', [
    'title'         => 'User Groups',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'User Groups' ]
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>team</th>
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>team</th>
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($userGroups as $userGroup)

                <tr data-id="{{ $userGroup->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $userGroup->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $userGroup->name !!}
                    </td>
                    <td data-field="team.name">
                        {!! $userGroup->team->name ?? '' !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $userGroup->abbreviation !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $userGroup->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('root.user-group.destroy', $userGroup->id) !!}" method="POST">

                            @if(canRead($userGroup))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('root.user-group.show', $userGroup->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($userGroup))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('root.user-group.edit', $userGroup->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($userGroup->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($userGroup->link_name) ? $userGroup->link_name : 'link',
                                    'href'   => $userGroup->link,
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

                            @if(canDelete($userGroup))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '6' : '5' }}">There are no user groups.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $userGroups->links('vendor.pagination.bulma') !!}

    </div>

@endsection
