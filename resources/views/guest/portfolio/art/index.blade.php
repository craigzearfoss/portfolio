@extends('guest.layouts.default', [
    'title' => $title ?? 'Art',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Art' ],
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
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>artist</th>
                <th>year</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($arts as $art)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $art->name,
                            'href'  => route('guest.portfolio.art.show', $art->slug),
                            'class' => $art->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        {{ $art->artist }}
                    </td>
                    <td class="has-text-centered">
                        {{ $art->year }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3">There is no art.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $arts->links('vendor.pagination.bulma') !!}

    </div>

@endsection
