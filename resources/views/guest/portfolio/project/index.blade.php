@php @endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' projects',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Projects' ],
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
                <th>language</th>
                <th>year</th>
                <th>repository</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>language</th>
                <th>year</th>
                <th>repository</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($projects as $project)

                <tr data-id="{{ $project->id }}">
                    <td data-field="name">
                        @include('guest.components.link', [
                            'name'  => $project->name,
                            'href'  => route('guest.portfolio.project.show', [$project->owner->label, $project->slug]),
                            'class' => $project->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="language">
                        {!! !empty($project->language)
                            ? ($project->language . (!empty($project->language_version) ? (' ' . $project->language_version) : ''))
                            : ''
                        !!}
                    </td>
                    <td data-field="year">
                        {!! $project->year !!}
                    </td>
                    <td data-field="year">
                        @if(!empty($project->repository_url))
                            @include('guest.components.link', [
                                'name'   => $project->repository_name,
                                'href'   => $project->repository_url,
                                'target' => '_blank'
                            ])
                        @endif
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no projects.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $projects->links('vendor.pagination.bulma') !!}

    </div>

@endsection
