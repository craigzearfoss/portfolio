@extends('admin.layouts.default', [
    'title' => 'Job Boards',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Job Boards' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Board', 'href' => route('admin.career.job-board.create') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                        {{ $jobBoard->name }}
                    </td>
                    <td data-field="primary" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobBoard->primary ])
                    </td>
                    <td data-field="international|national|regional|local" style="white-space: nowrap;">
                        {{ implode(', ', $jobBoard->coverageAreas ?? []) }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobBoard->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $jobBoard->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.job-board.destroy', $jobBoard->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.job-board.show', $jobBoard->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.job-board.edit', $jobBoard->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($jobBoard->link))
                                <a title="{{ !empty($jobBoard->link_name) ? $jobBoard->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $jobBoard->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- Delete --}}
                            </button>
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
