@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' courses',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('guest.homepage') ],
        [ 'name' => $admin->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.user.portfolio.index', $admin) ],
        [ 'name' => 'Courses' ],
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
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
                            'href'  => route('guest.user.portfolio.course.show', [$admin, $course->slug]),
                            'class' => $course->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        @if(!empty($course->academy['link']))
                            {{ $course->academy['name'] }}
                        @else
                            @include('guest.components.link', [
                                'name'   => $course->academy['name'],
                                'href'   => $course->academy['link'],
                                'target' => '_blank',
                            ])
                        @endif
                    </td>
                    <td>
                        {{ $course->instructor }}
                    </td>
                    <td>
                        {{ longDate($course->completion_date) }}
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

@endsection
