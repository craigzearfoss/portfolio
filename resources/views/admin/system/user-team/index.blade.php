@extends('admin.layouts.default', [
    'title'         => 'User Teams',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'User Teams' ]
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New User Team', 'href' => route('admin.system.user-team.create') ],
        [ 'name' => '<i class="fa fa-list"></i> User Groups',       'href' => route('admin.system.user-group.index') ],
    ],
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
                <th>abbreviation</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($userTeams as $userTeam)

                <tr data-id="{{ $userTeam->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $userTeam->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $userTeam->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $userTeam->abbreviation ?? '' !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $userTeam->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.system.user-team.destroy', $userTeam->id) !!}" method="POST">

                            @if(canRead($userTeam))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.system.user-team.show', $userTeam->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($userTeam))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.system.user-team.edit', $userTeam->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($userTeam->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($userTeam->link_name) ? $userTeam->link_name : 'link',
                                    'href'   => $userTeam->link,
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

                            @if(canDelete($userTeam))
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
                    <td colspan="{{ isRootAdmin() ? '5' : '4' }}">There are no user teams.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $userTeams->links('vendor.pagination.bulma') !!}

    </div>

@endsection
