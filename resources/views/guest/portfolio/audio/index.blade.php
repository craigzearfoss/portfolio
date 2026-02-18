@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Audio' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' audio',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
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
                            'href'  => route('guest.portfolio.audio.show', [$owner, $audio->slug]),
                            'class' => $audio->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="clip|podcast">
                        @php
                            $types = [];
                            if ($audio->podcast) $types[] = 'podcast';
                            if ($audio->clip) $types[] = 'clip';
                        @endphp
                        {!! implode(', ', $types) !!}
                    </td>
                    <td data-field="year">
                        {!! $audio->year !!}
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
