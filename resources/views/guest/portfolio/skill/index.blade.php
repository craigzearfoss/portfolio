@extends('guest.layouts.default', [
    'title' => $title ?? $admin->name . ' skills',
    'breadcrumbs' => [
        [ 'name' => 'Home',       'href' => route('system.homepage') ],
        [ 'name' => $admin->name, 'href' => route('guest.user.index', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.user.portfolio.index', $admin) ],
        [ 'name' => 'Skills' ],
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'    => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>category</th>
                <th>level (out of 10)</th>
                <th>years</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>category</th>
                <th>level (out of 10)</th>
                <th>years</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($skills as $skill)

                <tr>
                    <td>
                        @include('guest.components.link', [
                            'name'  => $skill->name,
                            'href'  => route('guest.user.portfolio.skill.show', [$admin, $skill->slug]),
                            'class' => $skill->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        {{ $skill->category['name'] ?? '' }}
                    </td>
                    <td data-field="level" style="white-space: nowrap;" class="is">
                        @include('admin.components.star-ratings', [
                            'rating' => $skill->level ?? 1,
                            'label'  => '(' . ($skill->level ?? 1) . ')'
                        ])
                    </td>
                    <td class="has-text-centered">
                        {{ $skill->years }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no links.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $skills->links('vendor.pagination.bulma') !!}

    </div>

@endsection
