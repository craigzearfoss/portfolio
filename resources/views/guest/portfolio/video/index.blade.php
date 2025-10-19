@php @endphp
@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' videos',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => $admin->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.user.portfolio.index', $admin) ],
        [ 'name' => 'Videos' ],
    ],
    'buttons' => [],
    'errors'  => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                            'href'  => route('guest.user.portfolio.video.show', [$admin, $video->slug]),
                            'class' => $video->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="year" class="has-text-centered">
                        {{ $video->year }}
                    </td>
                    <td data-field="show">
                        {{ $video->show }}
                    </td>
                    <td data-field="company">
                        {{ $video->company }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There is no video.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $videos->links('vendor.pagination.bulma') !!}

    </div>

@endsection
