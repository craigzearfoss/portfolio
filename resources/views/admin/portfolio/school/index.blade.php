@extends('admin.layouts.default', [
    'title' => 'Schools',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Schools' ]
    ],
    'buttons' => [
        canCreate('school')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New School', 'href' => route('admin.portfolio.school.create') ]]
            : [],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="search-container card p-2">
        <form id="searchForm" action="{{ route('admin.portfolio.school.index') }}" method="get">
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
                        {{ $school->name }}
                    </td>
                    <td data-field="logo_small">
                        @include('admin.components.image', [
                            'src'   => $school->logo_small,
                            'alt'   => $school->name,
                            'width' => '48px',
                        ])
                    </td>
                    <td data-field="city">
                        {{ $school->state['name'] ?? '' }}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.school.destroy', $school->id) }}" method="POST">

                            @if(canRead($school))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.school.show', $school->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($school))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.school.edit', $school) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($school->link))
                                <a title="{{ !empty($school->link_name) ? $school->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $school->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($school))
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
                    <td colspan="4">There are no schools.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $schools->links('vendor.pagination.bulma') !!}

    </div>

@endsection
