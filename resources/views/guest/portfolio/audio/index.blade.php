@php @endphp
@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' audio',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => $admin->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.user.portfolio.index', $admin) ],
        [ 'name' => 'Audio' ],
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
                <th>type</th>
                <th>year</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>type</th>
                <th>year</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($audios as $audio)

                <tr data-id="{{ $audio->id }}">
                    <td data-field="name">
                        @include('guest.components.link', [
                            'name'  => $audio->name,
                            'href'  => route('guest.user.portfolio.audio.show', [$admin, $audio->slug]),
                            'class' => $audio->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="clip|podcast">
                        @php
                            $types = [];
                            if ($audio->podcast) $types[] = 'podcast';
                            if ($audio->clip) $types[] = 'clip';
                        @endphp
                        {{ implode(', ', $types) }}
                    </td>
                    <td data-field="year">
                        {{ $audio->year }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3">There is no audio.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $audios->links('vendor.pagination.bulma') !!}

    </div>

@endsection
