@extends('admin.layouts.default', [
    'title' => 'Resumes',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Resumes' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'url' => route('admin.career.resume.create') ],
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
                <th>name</th>
                <th>date</th>
                <th class="has-text-centered">primary</th>
                <th class="has-text-centered">public</th>
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
                <th>name</th>
                <th>date</th>
                <th class="has-text-centered">primary</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($resumes as $resume)

                <tr data-id="{{ $resume->id }}">
                    @if(isRootAdmin())
                        <td>
                            @if(!empty($resume->admin))
                                @include('admin.components.link', [
                                    'name' => $resume->admin['username'],
                                    'url'  => route('admin.admin.show', $resume->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td>
                        {{ $resume->name }}
                    </td>
                    <td class="text-nowrap">
                        {{ shortDate($resume->date) }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->primary ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->public ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.resume.destroy', $resume->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.resume.show', $resume->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.resume.edit', $resume->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($resume->doc_url))
                                <a title="Microsoft Word document" class="button is-small px-1 py-0" href="{{ $resume->doc_url }}"
                                   target="_blank">
                                    <i class="fa-solid fa-file-word-o"></i>{{-- doc_url --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-file-word-o"></i>{{-- doc_url --}}
                                </a>
                            @endif

                            @if (!empty($resume->pdf_url))
                                <a title="PDF document" class="button is-small px-1 py-0" href="{{ $resume->pdf_url }}"
                                   target="_blank">
                                    <i class="fa-solid fa-file-pdf-o"></i>{{-- doc_url --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-file-pdf-o"></i>{{-- doc_url --}}
                                </a>
                            @endif

                            @if (!empty($resume->link))
                                <a title="{{ !empty($resume->link_name) ? $resume->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $resume->link }}"
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
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There are no resumes.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $resumes->links('vendor.pagination.bulma') !!}

    </div>

@endsection
