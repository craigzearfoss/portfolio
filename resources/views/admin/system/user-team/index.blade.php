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
                        {{ htmlspecialchars($userTeam->name ?? '') }}
                    </td>
                    <td data-field="abbreviation">
                        {{ htmlspecialchars($userTeam->abbreviation ?? ''0 }}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $userTeam->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.system.user-team.destroy', $userTeam->id) }}" method="POST">

                            @if(canRead($userTeam))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.system.user-team.show', $userTeam->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($userTeam))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.system.user-team.edit', $userTeam->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if(canDelete($userTeam))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
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
