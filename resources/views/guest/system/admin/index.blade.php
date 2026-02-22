@php
    $title    = $pageTitle ?? 'Candidates';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Candidates' ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($disclaimerMessage = config('app.demo_disclaimer'))
        @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <table class="table guest-table {{ $guestTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th></th>
                    <th>name</th>
                    <th>role</th>
                    <th>employer</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th style="white-space: nowrap;">user name</th>
                    <th>name</th>
                    <th>team</th>
                    <th>email</th>
                    <th>status</th>
                    <th class="has-text-centered">root</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($candidates as $candidate)

                    <tr data-id="{{ $candidate->id }}">
                        <td data-field="thumbnail" style="width: 32px;">
                            @if(!empty($candidate->thumbnail))
                                @include('guest.components.link', [
                                    'name' => view('guest.components.image', [
                                                    'src'      => $candidate->thumbnail,
                                                    'alt'      => 'profile image',
                                                    'width'    => '30px',
                                                    'filename' => $candidate->thumbnail
                                                ]),
                                    'href' => route('guest.admin.show', $candidate),
                                ])
                            @endif
                        </td>
                        <td data-field="name">
                            @include('guest.components.link', [
                                'name' => !empty($candidate->name) ? $candidate->name : $candidate->label,
                                'href' => route('guest.admin.show', $candidate),
                            ])
                        </td>
                        <td data-field="role">
                            {!! $candidate->role !!}
                        </td>
                        <td data-field="employer">
                            {!! $candidate->employer !!}
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">There are no candidates.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $candidates->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
