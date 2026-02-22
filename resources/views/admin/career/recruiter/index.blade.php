@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Recruiters';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => 'Recruiters' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'recruiter', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recruiter', 'href' => route('admin.career.recruiter.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $recruiters->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th>coverage area</th>
                    <th>location</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>coverage area</th>
                        <th>location</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($recruiters as $recruiter)

                    <tr data-id="{{ $recruiter->id }}">
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $recruiter->name !!}
                        </td>
                        <td data-field="international|national|regional|local" style="white-space: nowrap;">
                            {!! implode(', ', $recruiter->coverageAreas ?? []) !!}
                        </td>
                        <td data-field="location">
                            {!!
                                formatLocation([
                                    'city'    => $recruiter->city,
                                    'state'   => $recruiter->state->code ?? '',
                                ])
                            !!}
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $recruiter->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $recruiter->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $recruiter, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.recruiter.show', $recruiter),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $recruiter, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.recruiter.edit', $recruiter),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($recruiter->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($recruiter->link_name) ? $recruiter->link_name : 'link',
                                        'href'   => $recruiter->link,
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $recruiter, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.recruiter.destroy', $recruiter) !!}" method="POST">
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
                        <td colspan="6">There are no recruiters.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $recruiters->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
