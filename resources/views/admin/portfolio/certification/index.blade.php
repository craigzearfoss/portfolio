@extends('admin.layouts.default', [
    'title' => 'Certifications',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications' ],
    ],
    'buttons' => [
        canCreate('certification')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Certification', 'href' => route('admin.portfolio.certification.create') ]]
            : [],
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
                <th>abbreviation</th>
                <th>type</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>type</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($certifications as $certification)

                <tr data-id="{{ $certification->id }}">
                    <td data-field="name">
                        {{ $certification->name }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $certification->abbreviation }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $certification->certificationType->name }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certification->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certification->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.certification.destroy', $certification->id) }}" method="POST">

                            @if(canRead($certification))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.certification.show', $certification->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($certification))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.certification.edit', $certification->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($certification->link))
                                <a title="{{ !empty($certification->link_name) ? $certification->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $certification->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($certification))
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
                    <td colspan="6">There are no certifications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $certifications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
