@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Music' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' music',
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

    @if($owner->demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th>artist</th>
                    <th>year</th>
                    <th>label</th>
                    <th>cat#</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>artist</th>
                    <th>year</th>
                    <th>label</th>
                    <th>cat#</th>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($musics as $music)

                    <tr data-id="{{ $music->id }}">
                        <td data-field="name">
                            @include('guest.components.link', [
                                'name'  => $music->name,
                                'href'  => route('guest.portfolio.music.show', [$owner, $music->slug]),
                                'class' => $music->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td data-field="artist">
                            {!! $music->artist !!}
                        </td>
                        <td data-field="year">
                            {!! $music->year !!}
                        </td>
                        <td data-field="label">
                            {!! $music->label !!}
                        </td>
                        <td data-field="catalog_number">
                            {!! $music->catalog_number !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">There is no music.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $musics->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
