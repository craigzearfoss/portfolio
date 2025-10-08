@extends('guest.layouts.default', [
    'title' => $title ?? 'Skills',
    'breadcrumbs' => [
        [ 'name' => 'Home',      'href' => route('guest.homepage') ],
        [ 'name' => 'Portfolio', 'href' => route('guest.portfolio.index') ],
        [ 'name' => 'Skills' ],
    ],
    'buttons' => [],
    'errors'  => $errors->messages() ?? [],
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
                            'name'  => $skill->name . (!empty($skill->version) ? ' ' . $skill->version : ''),
                            'href'  => route('guest.portfolio.skill.show', $skill->slug),
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
                    <td colspan="2">There are no links.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $skills->links('vendor.pagination.bulma') !!}

    </div>

@endsection
