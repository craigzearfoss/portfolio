@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $admin->name . ' links',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $admin) ],
        [ 'name' => 'Links' ],
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
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
                            'href'  => route('guest.portfolio.link.show', [$admin, $link->slug]),
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
