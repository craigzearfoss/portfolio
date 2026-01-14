@php
    $buttons = [];
    if (canCreate('admin-group', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Add New Admin Group', 'href' => route('admin.admin-group.create') ];
    }
    if (canRead('admin-team', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-list"></i> Admin Teams', 'href' => route('admin.admin-team.index') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Admin Groups',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Admin Groups' ]
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

            @forelse ($adminGroups as $adminGroup)

                <tr data-id="{{ $adminGroup->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $adminGroup->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $adminGroup->name !!}
                    </td>
                    <td data-field="team.name">
                        {!! $adminGroup->team->name ?? '' !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $adminGroup->abbreviation !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $adminGroup->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.admin-group.destroy', $adminGroup->id) !!}" method="POST">

                            @if(canRead($adminGroup))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.admin-group.show', $adminGroup->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($adminGroup))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.admin-group.edit', $adminGroup->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if(canDelete($adminGroup))
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
                    <td colspan="{{ isRootAdmin() ? '6' : '5' }}">There are no admin groups.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $adminGroups->links('vendor.pagination.bulma') !!}

    </div>

@endsection
