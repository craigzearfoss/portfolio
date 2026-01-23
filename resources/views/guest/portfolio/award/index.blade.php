@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' awards',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Users',      'href' => route('guest.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Awards' ],
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
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
                            'href'  => route('guest.portfolio.award.show', [$owner, $award->slug]),
                            'class' => $award->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        @if(!empty($award->category))
                            @include('guest.components.link', [
                                'name'  => $award->category,
                                'href'  => route('guest.portfolio.award.show', [$owner, $award->slug]),
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
