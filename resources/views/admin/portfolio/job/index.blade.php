@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Jobs' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'job', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job', 'href' => route('admin.portfolio.job.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Jobs',
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
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.portfolio.job.index') ])
    @endif

    @if(!empty($resource->settings))

        <div class="card p-4" style="width: auto;">

            <div>
                Settings
            </div>
            <div>
            <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
                <thead>
                <tr>
                    <th>name</th>
                    <th>type</th>
                    <th>value</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($resource->settings as $setting)
                        <td>
                            {!! $setting->name !!}
                        </td>
                        <td>
                            {!! $setting->type->name !!}
                        </td>
                        <td>
                            {!! nl2br(htmlspecialchars($setting->value)) !!}
                        </td>
                    @endforeach
                </tbody>
            </table>
            </div>

        </div>

    @endif

    <div class="card p-4">

        @if($pagination_top)
            {!! $jobs->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>company</th>
                <th>logo</th>
                <th>role</th>
                <th class="has-text-centered">featured</th>
                <th>start date</th>
                <th>end date</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>company</th>
                    <th>logo</th>
                    <th>role</th>
                    <th class="has-text-centered">featured</th>
                    <th>start date</th>
                    <th>end date</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($jobs as $job)

                <tr data-id="{{ $job->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $job->owner->username }}
                        </td>
                    @endif
                    <td data-field="company">
                        {!! $job->company !!}
                    </td>
                    <td data-field="logo_small">
                        @include('admin.components.image', [
                            'src'   => $job->logo_small,
                            'alt'   => $job->name,
                            'width' => '48px',
                        ])
                    </td>
                    <td data-field="role">
                        {!! $job->role !!}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->featured ])
                    </td>
                    <td data-field="start_month|start_year">
                        @if(!empty($job->start_month)){!! date('F', mktime(0, 0, 0, $job->start_month, 10)) !!} @endif
                        {!! $job->start_year !!}
                    </td>
                    <td data-field="end_month|end_year">
                        @if(!empty($job->end_month)){!! date('F', mktime(0, 0, 0, $job->end_month, 10)) !!} @endif
                        {!! $job->end_year !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $job->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $job, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.job.show', $job),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $job, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.job.edit', $job),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($job->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($job->link_name) ? $job->link_name : 'link',
                                    'href'   => $job->link,
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

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $job, $admin))
                                <form class="delete-resource" action="{!! route('admin.portfolio.job.destroy', $job) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '10' : '9' }}">There are no jobs.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $jobs->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
