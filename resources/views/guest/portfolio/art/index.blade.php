@extends('guest.layouts.default', [
    'title'         => $title ?? $admin->name . ' art',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Art' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin ?? null,
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
                            'name'  => htmlspecialchars($art->name ?? ''),
                            'href'  => route('guest.admin.portfolio.art.show', [$admin, $art->slug]),
                            'class' => $art->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        {{ htmlspecialchars($art->artist ?? '') }}
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
