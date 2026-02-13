@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',   'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',   'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Applications' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'application', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Application', 'href' => route('admin.career.application.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Applications' . (!empty($resume) ? ' for ' . $resume->name . ' resume' : ''),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.career.application.index') ])
    @endif

    <div class="card p-4">

        @if($pagination_top)
            {!! $applications->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>name</th>
                <?php /*
                    <th>company</th>
                    <th>role</th>
                */ ?>
                <th>active</th>
                <th>rating</th>
                <?php /*
                    <th>posted</th>
                */ ?>
                <th>applied</th>
                <th>compensation</th>
                <?php /*
                    <th>duration</th>
                */ ?>
                <th class="has-text-centered">type</th>
                <th class="has-text-centered">location</th>
                <th>location</th>
                <?php /*
                    <th class="has-text-centered">w2</th>
                    <th class="has-text-centered">relo</th>
                    <th class="has-text-centered">ben</th>
                    <th class="has-text-centered">vac</th>
                    <th class="has-text-centered">health</th>
                    <th>source</th>
                */ ?>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <?php /*
                        <th>company</th>
                        <th>role</th>
                    */ ?>
                    <th>active</th>
                    <th>rating</th>
                    <?php /*
                        <th>posted</th>
                    */ ?>
                    <th>applied</th>
                    <th>compensation</th>
                    <?php /*
                        <th>duration</th>
                    */ ?>
                    <th class="has-text-centered">type</th>
                    <th class="has-text-centered">location</th>
                    <th>location</th>
                    <?php /*
                        <th class="has-text-centered">w2</th>
                        <th class="has-text-centered">relo</th>
                        <th class="has-text-centered">ben</th>
                        <th class="has-text-centered">vac</th>
                        <th class="has-text-centered">health</th>
                        <th>source</th>
                    */ ?>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($applications as $application)

                <tr data-id="{{ $application->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $application->owner->username }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $application->name !!}
                    </td>
                    <?php /*
                    <td data-field="company.name" style="white-space: nowrap;">
                        @if(!empty($application->company))
                            @include('admin.components.link', [
                                'name' => $application->company->name ?? '',
                                'href' => route('admin.career.company.show',
                                                \App\Models\Career\Company::find($application->company->id
                                          )
                            ])
                        @endif
                    </td>
                    <td data-field="role">
                        {!! $application->role !!}
                    </td>
                    */ ?>
                    <td data-field="active" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->active ])
                    </td>
                    <td data-field="rating" class="has-text-centered ">
                        @include('admin.components.star-ratings', [ 'rating' => $application->rating ])
                    </td>
                    <?php /*
                    <td data-field="post_date" style="white-space: nowrap;">
                        {!! !empty($application->post_date) ? date('M j', strtotime($application->post_date)) : '' !!}
                    </td>
                    */ ?>
                    <td data-field="apply_date" style="white-space: nowrap;">
                        {!! !empty($application->apply_date) ? date('M j', strtotime($application->apply_date)) : '' !!}
                    </td>
                    <td data-field="compensation" style="white-space: nowrap;">
                        {!!
                            formatCompensation([
                                'min'   => $application->compensation_min,
                                'max'   => $application->compensation_max,
                                'unit'  => $application->compensationUnit->abbreviation ?? '',
                                'short' => true
                            ])
                        !!}
                    </td>
                    <?php /*
                    <td data-field="job_duration_id">
                        {!! $application->durationType['name'] ?? '' !!}
                    </td>
                    */ ?>
                    <td data-field="job_employment_type_id" class="has-text-centered" style="white-space: nowrap;">
                        {!! $application->employmentType->name ?? '' !!}
                    </td>
                    <td data-field="job_location_type_id" class="has-text-centered">
                        {!! $application->locationType->name ?? '' !!}
                    </td>
                    <td data-field="location">
                        {!!
                            formatLocation([
                                'city'    => $application->city,
                                'state'   => $application->state->code ?? '',
                            ])
                        !!}
                    </td>
                    <?php /*
                    <td data-field="w2" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->w2 ])
                    </td>
                    <td data-field="relocation" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->relocation ])
                    </td>
                    <td data-field="benefits" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->benefits ])
                    </td>
                    <td data-field="vacation" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->vacation ])
                    </td>
                    <td data-field="health" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $application->health ])
                    </td>
                    <td data-field="job_board_id">
                        {!! $application->jobBoard->name ?? '' }}
                    </td>
                    */ ?>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $application, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.application.show', $application),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $application, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.application.edit', $application),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($application->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($application->link_name) ? $application->link_name : 'link',
                                    'href'   => $application->link,
                                    'icon'   => 'fa-external-link',
                                    'target' => '_blank'
                                ])
                            @else
                                @include('admin.components.link-icon', [
                                    'title'    => 'link',
                                    'icon'     => 'fa-external-link',
                                    'disabled' => true
                                ])
                            @endif

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $application, $admin))
                                <form class="delete-resource" action="{!! route('admin.career.application.destroy', $application) !!}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @include('admin.components.button-icon', [
                                        'title' => 'delete',
                                        'class' => 'delete-btn',
                                        'icon'  => 'fa-trash'
                                    ])
                                </form>
                            @endif

                        </div>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ $admin->root ? '10' : '9' }}">There are no applications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $applications->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
