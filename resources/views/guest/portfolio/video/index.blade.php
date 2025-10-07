@php @endphp
@extends('guest.layouts.default', [
    'title' => $title ?? 'Videos',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage')],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Videos']
    ],
    'buttons' => [],
    'errors'  => $errors->any()  ?? [],
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
                            'name' => $video->name,
                            'href' => route('guest.portfolio.video.show', $video->slug),
                            'class' => $video->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="year">
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
                    <td colspan="4">There are no videos.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $videos->links('vendor.pagination.bulma') !!}

    </div>

@endsection
