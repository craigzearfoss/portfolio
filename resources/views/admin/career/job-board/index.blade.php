@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => 'Job Boards' ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate('job-board', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Board', 'href' => route('admin.career.job-board.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Job Boards',
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

    <div class="card p-4">

        @if($pagination_top)
            {!! $jobBoards->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th class="has-text-centered">primary</th>
                <th>coverage area</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>name</th>
                    <th class="has-text-centered">primary</th>
                    <th>coverage area</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($jobBoards as $jobBoard)

                <tr data-id="{{ $jobBoard->id }}">
                    <td data-field="name">
                        {!! $jobBoard->name !!}
                    </td>
                    <td data-field="primary" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobBoard->primary ])
                    </td>
                    <td data-field="international|national|regional|local" style="white-space: nowrap;">
                        {!! implode(', ', $jobBoard->coverageAreas ?? []) !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobBoard->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobBoard->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($jobBoard, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.job-board.show', $jobBoard),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($jobBoard, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.job-board.edit', $jobBoard),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($jobBoard->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($jobBoard->link_name) ? $jobBoard->link_name : 'link',
                                    'href'   => $jobBoard->link,
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

                            @if(canDelete($jobBoard, $admin))
                                <form class="delete-resource" action="{!! route('admin.career.job-board.destroy', $jobBoard) !!}" method="POST">
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
                    <td colspan="6">There are no job boards.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $jobBoards->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
