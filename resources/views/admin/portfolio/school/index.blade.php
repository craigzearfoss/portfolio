@php
    $buttons = [];
    if (canCreate('school', loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New School', 'href' => route('admin.portfolio.school.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Schools',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Schools' ]
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
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

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>logo</th>
                <th>state</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>logo</th>
                <th>state</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
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
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.portfolio.school.destroy', $school->id) !!}" method="POST">

                            @if(canRead($school))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.school.show', $school->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($school))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.school.edit', $school->id),
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

                            @if(canDelete($school))
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
                    <td colspan="4">There are no schools.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $schools->links('vendor.pagination.bulma') !!}

    </div>

@endsection
