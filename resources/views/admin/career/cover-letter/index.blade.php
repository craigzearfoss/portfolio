@extends('admin.layouts.default', [
    'title' => 'Cover Letters',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Cover Letter', 'url' => route('admin.career.cover-letter.create') ],
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
                @if(isRootAdmin())
                    <th>admin</th>
                @endif
                <th>company</th>
                <th>role</th>
                <th>apply</th>
                <th>active</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>admin</th>
                @endif
                <th>company</th>
                <th>role</th>
                <th>apply</th>
                <th>active</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($coverLetters as $coverLetter)

                <tr data-id="{{ $coverLetter->id }}">
                    @if(isRootAdmin())
                        <td>
                            {{ $application->admin['username'] ?? '' }}
                        </td>
                    @endif
                    <td>
                        {{ $coverLetter->application->company['name'] ?? '' }}
                    </td>
                    <td>
                        {{ $coverLetter->application['role'] ?? '' }}
                    </td>
                    <td class="text-nowrap">
                        {{ shortDate($coverLetter->application['post_date'] ?? null) }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $coverLetter->application['active'] ?? 0 ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $coverLetter->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.cover-letter.destroy', $coverLetter->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.cover-letter.show', $coverLetter->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.cover-letter.edit', $coverLetter->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($coverLetter->link))
                                <a title="{{ !empty($coverLetter->link_name) ? $coverLetter->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $coverLetter->link }}"
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
                    <td colspan="{{ isRootAdmin() ? '8' : '7' }}">There are no cover letters.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $coverLetters->links('vendor.pagination.bulma') !!}

    </div>

@endsection
