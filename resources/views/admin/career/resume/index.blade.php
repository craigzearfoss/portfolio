@extends('admin.layouts.default', [
    'title' => 'Resumes',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Resumes' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.career.resume.create') ],
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
                    <th>owner</th>
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
                        <td data-field="owner.username">
                            {{ $resume->owner['username'] ?? '' }}
                        </td>
                    @endif
                    <td data-field="name" style="white-space: nowrap;">
                        {{ $resume->name }}
                    </td>
                    <td data-field="date" style="white-space: nowrap;">
                        {{ shortDate($resume->date) }}
                    </td>
                    <td data-field="primary" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->primary ])
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.resume.destroy', $resume->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.resume.show', $resume->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.resume.edit', $resume->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($resume->doc_url))
                                <a title="Open Microsoft Word document"
                                   class="button is-small px-1 py-0"
                                   href="{{ $resume->doc_url }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-file-word"></i>{{-- doc_url --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-file-word"></i>{{-- doc_url --}}
                                </a>
                            @endif

                            @if (!empty($resume->pdf_url))
                                <a title="Open PDF document"
                                   class="button is-small
                                   px-1 py-0" href="{{ $resume->pdf_url }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-file-pdf"></i>{{-- pdf_url --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-file-pdf"></i>{{-- pdf_url --}}
                                </a>
                            @endif

                            @if (!empty($resume->link))
                                <a title="{{ !empty($resume->link_name) ? $resume->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $resume->link }}"
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
                            <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- delete --}}
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
