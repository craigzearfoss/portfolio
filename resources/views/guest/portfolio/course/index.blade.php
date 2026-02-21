@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Courses' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' courses',
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
                    <th>academy</th>
                    <th>instructor</th>
                    <th style="white-space: nowrap;">completion date</th>
                </tr>
                </thead>
                <?php /*
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>academy</th>
                    <th>instructor</th>
                    <th style="white-space: nowrap;">completion date</th>
                </tr>
                </tr>
                </tfoot>
                */ ?>
                <tbody>

                @forelse ($courses as $course)

                    <tr>
                        <td>
                            @include('guest.components.link', [
                                'name'  => $course->name,
                                'href'  => route('guest.portfolio.course.show', [$owner, $course->slug]),
                                'class' => $course->featured ? 'has-text-weight-bold' : ''
                            ])
                        </td>
                        <td>
                            @if(!empty($course->academy->link))
                                {!! $course->academy->name !!}
                            @else
                                @include('guest.components.link', [
                                    'name'   => $course->academy->name] ?? ''),
                                    'href'   => $course->academy->link ?? '',
                                    'target' => '_blank',
                                ])
                            @endif
                        </td>
                        <td>
                            {!! $course->instructor !!}
                        </td>
                        <td>
                            {!! longDate($course->completion_date) !!}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">There are no courses.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            {!! $courses->links('vendor.pagination.bulma') !!}

        </div>
    </div>

@endsection
