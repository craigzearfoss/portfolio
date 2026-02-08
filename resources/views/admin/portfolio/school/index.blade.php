@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => 'Schools' ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'school', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New School', 'href' => route('admin.portfolio.school.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Schools',
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

    <div class="search-container card p-2">
        <form id="searchForm" action="{!! route('admin.portfolio.school.index') !!}" method="get">
            <div class="control">
                @include('admin.components.form-select', [
                    'name'     => 'state_id',
                    'label'    => 'state',
                    'value'    => Request::get('state_id'),
                    'list'     => \App\Models\System\State::listOptions([], 'id', 'name', true, false, ['name', 'asc']),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>
        </form>
    </div>

    <div class="card p-4">

        @if($pagination_top)
            {!! $schools->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>logo</th>
                <th>state</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>logo</th>
                    <th>state</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($schools as $school)

                <tr data-id="{{ $school->id }}">
                    <td data-field="name">
                        {!! $school->name !!}
                    </td>
                    <td data-field="logo_small">
                        @include('admin.components.image', [
                            'src'   => $school->logo_small,
                            'alt'   => $school->name,
                            'width' => '48px',
                        ])
                    </td>
                    <td data-field="state">
                        {!! $school->state['name'] ?? '' !!}
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $school, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.school.show', $school),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $school, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.school.edit', $school),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($school->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($school->link_name) ? $school->link_name : 'link',
                                    'href'   => $school->link,
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

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $school, $admin))
                                <form class="delete-resource" action="{!! route('admin.portfolio.school.destroy', $school) !!}" method="POST">
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
                    <td colspan="4">There are no schools.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $schools->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
