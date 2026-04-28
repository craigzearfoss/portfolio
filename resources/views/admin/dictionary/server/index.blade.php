@php
    use App\Models\Dictionary\Server;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Dictionary\Server';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = 'Dictionary (servers)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Servers' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Server::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Server', 'href' => route('admin.dictionary.server.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container" style="max-width: 50em !important;">

        <div class="show-container card floating-div">

            @if(!empty($pagination_top))
                {!! $servers->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>abbrev</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>abbrev</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($servers as $server)

                    @php
                        // don't displace the entry for "other"
                        if ($server->name == 'other') continue;
                    @endphp

                    <tr data-id="{{ $server->id }}">
                        <td data-field="name">
                            {!! $server->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $server->abbreviation !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $server->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $server->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($server, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.dictionary.server.show', $server),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($server, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.dictionary.server.edit', $server),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($server->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($server->link_name) ? $server->link_name : 'link',
                                        'href'   => $server->link,
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

                                @if (!empty($server->wikipedia))
                                    @include('admin.components.link-icon', [
                                        'title'  => 'Wikipedia page',
                                        'href'   => $server->wikipedia,
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

                                @if(canDelete($server, $admin))
                                    <form class="delete-resource" action="{!! route('admin.dictionary.server.destroy', $server) !!}" method="POST">
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
                        <td colspan="5">No servers found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $servers->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
