@php @endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' videos',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Users',      'href' => route('guest.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Videos' ],
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
                <th>year</th>
                <th>show</th>
                <th>company</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>year</th>
                <th>show</th>
                <th>company</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($videos as $video)

                <tr data-id="{{ $video->id }}">
                    <td data-field="name">
                        @include('guest.components.link', [
                            'name'  => $video->name,
                            'href'  => route('guest.portfolio.video.show', [$owner, $video->slug]),
                            'class' => $video->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="year" class="has-text-centered">
                        {!! $video->year !!}
                    </td>
                    <td data-field="show">
                        {!! $video->show !!}
                    </td>
                    <td data-field="company">
                        {!! $video->company !!}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no videos.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $videos->links('vendor.pagination.bulma') !!}

    </div>

@endsection
