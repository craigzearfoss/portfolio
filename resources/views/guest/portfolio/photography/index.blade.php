@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Photography' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' photography',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
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
                            'href'  => route('guest.portfolio.photography.show', [$owner, $photo->slug]),
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
