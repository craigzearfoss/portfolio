@extends('admin.layouts.default', [
    'title' => 'Recruiters',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recruiter', 'href' => route('admin.career.recruiter.create') ],
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
                <th>coverage area</th>
                <th>location</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>coverage area</th>
                <th>location</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recruiters as $recruiter)

                <tr data-id="{{ $recruiter->id }}">
                    <td data-field="name" style="white-space: nowrap;">
                        {{ $recruiter->name }}
                    </td>
                    <td data-field="international|national|regional|local" style="white-space: nowrap;">
                        {{ implode(', ', $recruiter->coverageAreas ?? []) }}
                    </td>
                    <td data-field="location">
                        {!!
                            formatLocation([
                                'city'    => $recruiter->city ?? null,
                                'state'   => $recruiter->state['code'] ?? null,
                            ])
                        !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.recruiter.destroy', $recruiter->id) }}" method="POST">

                            @if(canRead($recruiter))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.recruiter.show', $recruiter->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($recruiter))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.recruiter.edit', $recruiter->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($recruiter->link))
                                <a title="{{ !empty($recruiter->link_name) ? $recruiter->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $recruiter->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if (!empty($recruiter->postings_url))
                                <a title="job postings"
                                   class="button is-small px-1 py-0"
                                   href="{{ $recruiter->postings_url }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link-square"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link-square"></i>
                                </a>
                            @endif

                            @if(canDelete($recruiter))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6">There are no recruiters.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recruiters->links('vendor.pagination.bulma') !!}

    </div>

@endsection
