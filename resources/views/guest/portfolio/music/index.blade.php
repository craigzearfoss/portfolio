@extends('guest.layouts.default', [
    'title' => $title ?? 'Music',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Music' ],
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>artist</th>
                <th>year</th>
                <th>label</th>
                <th>cat#</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>artist</th>
                <th>year</th>
                <th>label</th>
                <th>cat#</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($musics as $music)

                <tr data-id="{{ $music->id }}">
                    <td data-field="name">
                        @include('guest.components.link', [
                            'name'  => $music->name,
                            'href'  => route('guest.portfolio.music.show', $music->slug),
                            'class' => $music->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="artist">
                        {{ $music->artist }}
                    </td>
                    <td data-field="year">
                        {{ $music->year }}
                    </td>
                    <td data-field="label">
                        {{ $music->label }}
                    </td>
                    <td data-field="catalog_number">
                        {{ $music->catalog_number }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There is no music.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $musics->links('vendor.pagination.bulma') !!}

    </div>

@endsection
