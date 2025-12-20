@php
$buttons = [];
if (canCreate('user-group', currentAdminId())) {
    $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Add New User Group', 'href' => route('admin.system.user-group.create') ];
}
if (canRead('user-team', currentAdminId())) {
    $buttons[] = [ 'name' => '<i class="fa fa-list"></i> User Teams', 'href' => route('admin.system.user-team.index') ];
}
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Admin Groups',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'User Groups' ]
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
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
                        {{ $userGroup->name }}
                    </td>
                    <td data-field="team.name">
                        {{ $userGroup->team['name'] ?? '' }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $userGroup->abbreviation }}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $userGroup->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.system.admin-group.destroy', $userGroup->id) }}" method="POST">

                            @if(canRead($userGroup))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.system.admin-group.show', $userGroup->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($userGroup))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.system.admin-group.edit', $userGroup->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if(canDelete($userGroup))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>{{-- delete --}}
                                </button>
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
