@extends('guest.layouts.default', [
    'title'         => $pageTitle ?? $admin->name . ' photography',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $admin) ],
        [ 'name' => 'Photography' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'loggedInAdmin' => $loggedInAdmin,
    'loggedInUser'  => $loggedInUser,
    'admin'         => $admin,
    'user'          => $user
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>credit</th>
                <th>year</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>credit</th>
                <th>year</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($photos as $photo)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $photo->name,
                            'href'  => route('guest.portfolio.photography.show', [$admin, $photo->slug]),
                            'class' => $photo->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        {!! $photo->credit !!}
                    </td>
                    <td class="has-text-centered">
                        {!! $photo->year !!}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="2">There are no photos.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $photos->links('vendor.pagination.bulma') !!}

    </div>

@endsection
