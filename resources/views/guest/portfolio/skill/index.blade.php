@extends('guest.layouts.default', [
    'title'         => $title ?? $admin->name . ' skills',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Skills' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin ?? null,
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
                            'name'  => htmlspecialchars($skill->name ?? ''),
                            'href'  => route('guest.admin.portfolio.skill.show', [$admin, $skill->slug]),
                            'class' => $skill->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        {{ htmlspecialchars($skill->category['name'] ?? '') }}
                    </td>
                    <td data-field="level" style="white-space: nowrap;" class="is">
                        @if(!empty($skill->level))
                            @include('guest.components.star-ratings', [
                                'rating' => $skill->level ?? 1,
                                'label'  => '(' . ($skill->level ?? 1) . ')'
                            ])
                        @endif
                    </td>
                    <td class="has-text-centered">
                        {{ $skill->years }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no skills.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $skills->links('vendor.pagination.bulma') !!}

    </div>

@endsection
