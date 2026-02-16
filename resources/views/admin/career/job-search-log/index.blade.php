@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Companies' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'job-search-log', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Log Entry', 'href' => route('admin.career.job-search-log.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Job Search Log',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.career.job-search-log.index') ])
    @endif

    <div class="card p-4">

        @if($pagination_top)
            {!! $jobSearchLogs->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table admin-table">
            <thead>
            <tr>
                @if($admin->root)
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>industry</th>
                <th>location</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>industry</th>
                    <th>location</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($jobSearchLogs as $jobSearchLog)

                <tr data-id="{{ $jobSearchLog->id }}">
                    @if(!empty($admin->root))
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $jobSearchLog->owner->username }}
                        </td>
                    @endif
                    <td data-field="time_logged">
                        {!! $jobSearchLog->time_logged !!}
                    </td>
                    <td data-field="message">
                        {!! $jobSearchLog->message !!}
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(PermissionEntityTypes::RESOURCE, $jobSearchLog, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.job-search-log.show', $jobSearchLog),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canDelete(PermissionEntityTypes::RESOURCE, $jobSearchLog, $admin))
                                <form class="delete-resource"
                                      action="{!! route('admin.career.job-search-log.destroy', $jobSearchLog) !!}"
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
                    <td colspan="{{ $admin->root ? '5' : '4' }}">There are no log entries.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $jobSearchLogs->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
