@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' links',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.homepage') ],
        [ 'name' => $admin->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.user.portfolio.index', $admin) ],
        [ 'name' => 'Links' ],
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
                            'href'  => route('guest.user.portfolio.link.show', [$admin, $link->slug]),
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
