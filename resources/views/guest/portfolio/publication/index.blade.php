@php @endphp
@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' publications',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.index', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.index', $admin) ],
        [ 'name' => 'publications' ],
    ],
    'buttons' => [],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>title</th>
                <th>publication</th>
                <th>publisher</th>
                <th>year</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>title</th>
                <th>publication</th>
                <th>publisher</th>
                <th>year</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($publications as $publication)

                <tr data-id="{{ $publication->id }}">
                    <td data-field="title">
                        @include('guest.components.link', [
                            'name'  => $publication->name,
                            'href'  => route('guest.admin.portfolio.publication.show', [$admin, $publication->slug]),
                            'class' => $publication->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="publication_name">
                        {{ $publication->publication_name }}
                    </td>
                    <td data-field="publisher">
                        {{ $publication->publisher }}
                    </td>
                    <td data-field="year" class="has-text-centered">
                        {{ $publication->year }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no publications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $publications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
