@extends('admin.layouts.default', [
    'title' => 'Academies',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies' ],
    ],
    'buttons' =>
        canCreate('academy')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Academy', 'href' => route('admin.portfolio.academy.create') ]]
            : [],
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
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($academies as $academy)

                <tr data-id="{{ $academy->id }}">
                    <td data-field="name">
                        {{ $academy->name }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $academy->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $academy->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.academy.destroy', $academy->id) }}" method="POST">

                            @if(canRead($academy))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.academy.show', $academy->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($academy))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.academy.edit', $academy->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($academy->link))
                                <a title="{{ !empty($academy->link_name) ? $academy->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $academy->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($academy))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="button" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no academies.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $academies->links('vendor.pagination.bulma') !!}

    </div>

@endsection
