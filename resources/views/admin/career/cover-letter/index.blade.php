@extends('admin.layouts.default', [
    'title' => 'Cover Letters',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
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
                    <th>owner</th>
                @endif
                <th>company</th>
                <th>role</th>
                <th style="white-space: nowrap;">apply date</th>
                <th class="has-text-centered">active</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>company</th>
                <th>role</th>
                <th style="white-space: nowrap;">apply date</th>
                <th class="has-text-centered">active</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($coverLetters as $coverLetter)

                <tr data-id="{{ $coverLetter->id }}">
                    @if(isRootAdmin())
                        <td data-field="admin.username">
                            @if(!empty($coverLetter->admin))
                                @include('admin.components.link', [
                                    'name' => $coverLetter->admin['username'],
                                    'href' => route('admin.admin.show', $coverLetter->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="company.name" style="white-space: nowrap;">
                        {{ $coverLetter->application->company['name'] ?? '' }}
                    </td>
                    <td data-field="role" style="white-space: nowrap;">
                        {{ $coverLetter->application['role'] ?? '' }}
                    </td>
                    <td data-field="post_date" style="white-space: nowrap;">
                        {{ shortDate($coverLetter->application['apply_date'] ?? null) }}
                    </td>
                    <td data-field="application.active" data-field="" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $coverLetter->application['active'] ?? 0 ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $coverLetter->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.cover-letter.destroy', $coverLetter->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.cover-letter.show', $coverLetter->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.cover-letter.edit', $coverLetter->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($coverLetter->link))
                                <a title="{{ !empty($coverLetter->link_name) ? $coverLetter->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $coverLetter->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There are no cover letters.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $coverLetters->links('vendor.pagination.bulma') !!}

    </div>

@endsection
