@extends('guest.layouts.default', [
    'title' => $title ?? 'Links',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Links' ],
    ],
    'buttons' => [],
    'errors'  => $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>url</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>url</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($links as $link)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $link->name,
                            'href'  => route('guest.portfolio.link.show', $link->slug),
                            'class' => $link->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        @include('guest.components.link', [
                            'name'   => $link->url,
                            'href'   => $link->url,
                            'target' => '_blank',
                        ])
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="2">There are no links.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $links->links('vendor.pagination.bulma') !!}

    </div>

@endsection
