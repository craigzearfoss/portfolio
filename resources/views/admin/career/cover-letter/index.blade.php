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
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>date</th>
                <th class="text-center">primary</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>date</th>
                <th class="text-center">primary</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($coverLetters as $coverLetter)

                <tr>
                    <td>
                        {{ $coverLetter->name }}
                    </td>
                    <td class="text-nowrap">
                        {{ shortDate($coverLetter->date) }}
                    </td>
                    <td class="text-center">
                        @include('admin.components.checkmark', [ 'checked' => $coverLetter->primary ])
                    </td>
                    <td class="text-center">
                        @include('admin.components.checkmark', [ 'checked' => $coverLetter->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.cover-letter.destroy', $coverLetter->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.cover-letter.show', $coverLetter->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.cover-letter.edit', $coverLetter->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($coverLetter->link))
                                <a title="link" class="button is-small px-1 py-0" href="{{ $coverLetter->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no jobs.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $coverLetters->links('vendor.pagination.bulma') !!}

    </div>

@endsection
