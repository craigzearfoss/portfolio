@php @endphp
@extends('guest.layouts.default', [
    'title'         => $title ?? $admin->name . ' projects',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.admin.portfolio.show', $admin) ],
        [ 'name' => 'Projects' ],
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
                            'name'  => htmlspecialchars($project->name ?? ''),
                            'href'  => route('guest.admin.portfolio.project.show', [$project->owner->label, $project->slug]),
                            'class' => $project->featured ? 'has-text-weight-bold' : ''
                        ])
                    </td>
                    <td data-field="language">
                        {{ !empty($project->language)
                            ? htmlspecialchars(($project->language . (!empty($project->language_version) ? (' ' . $project->language_version) : '')))
                            : ''
                        }}
                    </td>
                    <td data-field="year">
                        {{ $project->year }}
                    </td>
                    <td data-field="year">
                        @if(!empty($project->repository_url))
                            @include('guest.components.link', [
                                'name'   => htmlspecialchars($project->repository_name ?? ''),
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
<?php /*
@extends('guest.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('guest.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('guest.components.header')

                @include('guest.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Projects</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('guest.components.messages', [$errors])
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th>name</th>
                            <th>featured</th>
                            <th>year</th>
                            <th>repository</th>
                            <th>link</th>
                            <th>description</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($projects as $project)

                            <tr>
                                <td>
                                    @include('guest.components.link', [
                                        'name' => $project->name,
                                        'href' => route('guest.portfolio.project.show', $project->slug)
                                    ])
                                </td>
                                <td class="has-text-centered">
                                    @include('guest.components.checkmark', [ 'checked' => $music->featured ])
                                </td>
                                <td>
                                    {{ $project->year }}
                                </td>
                                <td>
                                    @include('guest.components.link', [ 'href' => $project->repository, 'target' => '_blank' ])
                                </td>
                                <td>
                                    @include('guest.components.link', [ 'href' => $project->link, 'target' => '_blank' ])
                                </td>
                                <td>
                                    {!! nl2br($project->description ?? '') !!}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8">There are no projects.</td>
                            </tr>

                        @endforelse

                        </tbody>
                    </table>

                    {!! $projects->links() !!}

                    @include('guest.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
*/ ?>
