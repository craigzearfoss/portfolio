@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $admin->name . ' awards',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $admin) ],
        [ 'name' => 'Awards' ],
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
                <th>category</th>
                <th>nominated work</th>
                <th>year</th>
                <th>organization</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>category</th>
                <th>nominated work</th>
                <th>year</th>
                <th>organization</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($awards as $award)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $award->name,
                            'href'  => route('guest.portfolio.award.show', [$admin, $award->slug]),
                            'class' => $award->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        @if(!empty($award->category))
                            @include('guest.components.link', [
                                'name'  => $award->category,
                                'href'  => route('guest.portfolio.award.show', [$admin, $award->slug]),
                                'class' => $award->featured ? 'has-text-weight-bold' : ''
                            ])
                        @endif
                    </td>
                    <td>
                        {!! $award->nominated_work !!}
                    </td>
                    <td class="has-text-centered">
                        {!! $award->year !!}
                    </td>
                    <td>
                        {!! $award->organization !!}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no awards.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $awards->links('vendor.pagination.bulma') !!}

    </div>

@endsection
