@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' skills',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Skills' ],
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
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
                            'href'  => route('guest.portfolio.skill.show', [$owner, $skill->slug]),
                            'class' => $skill->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td>
                        {!! $skill->category->name ?? '' !!}
                    </td>
                    <td data-field="level" style="white-space: nowrap;" class="is">
                        @if(!empty($skill->level))
                            @include('guest.components.star-ratings', [
                                'rating' => $skill->level,
                                'label'  => "({$skill->level})"
                            ])
                        @endif
                    </td>
                    <td class="has-text-centered">
                        {!! $skill->years !!}
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
