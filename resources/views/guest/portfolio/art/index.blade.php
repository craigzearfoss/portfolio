@extends('guest.layouts.default', [
    'title'         => $pageTitle ?? $currentAdmin->name . ' art',
    'breadcrumbs'   => [
        [ 'name' => 'Home',              'href' => route('home') ],
        [ 'name' => 'Users',             'href' => route('home') ],
        [ 'name' => $currentAdmin->name, 'href' => route('guest.admin.show', $currentAdmin)],
        [ 'name' => 'Portfolio',         'href' => route('guest.portfolio.index', $currentAdmin) ],
        [ 'name' => 'Art' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $currentAdmin,
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
                            'href'  => route('guest.portfolio.art.show', [$currentAdmin, $art->slug]),
                            'class' => $art->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        {!! $art->artist !!}
                    </td>
                    <td class="has-text-centered">
                        {!! $art->year !!}
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
