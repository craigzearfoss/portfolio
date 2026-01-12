@php
    $buttons = [];
    if (canCreate('job-board', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Job Board', 'href' => route('admin.career.job-board.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Job Boards',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards' ]
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
                <th>name</th>
                <th class="has-text-centered">primary</th>
                <th>coverage area</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
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
            */ ?>
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
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.career.job-board.destroy', $jobBoard->id) !!}" method="POST">

                            @if(canRead($jobBoard))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.job-board.show', $jobBoard->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($jobBoard))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.job-board.edit', $jobBoard->id),
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

                            @if(canDelete($jobBoard))
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
                    <td colspan="6">There are no job boards.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $jobBoards->links('vendor.pagination.bulma') !!}

    </div>

@endsection
