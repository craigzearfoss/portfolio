@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Projects' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' projects',
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
    </div>

@endsection
