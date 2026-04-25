@php
    use App\Models\Career\Recruiter;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Recruiter';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

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
    if (canCreate(Recruiter::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recruiter', 'href' => route('admin.career.recruiter.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-recruiter')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.recruiter.export', request()->except([ 'page' ])),
                'filename' => 'recruiters_' . date("Y-m-d-His") . '.xlsx',
            ])

            @if($pagination_top)
                {!! $recruiters->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>coverage area</th>
                        <th>location</th>
                        <th class="has-text-centered" style="display: none;">public</th>
                        <th class="has-text-centered" style="display: none;">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>coverage area</th>
                        <th>location</th>
                        <th class="has-text-centered" style="display: none;">public</th>
                        <th class="has-text-centered" style="display: none;">disabled</th>
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
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $recruiter->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $recruiter->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($recruiter, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.recruiter.show', $recruiter),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($recruiter, $admin))
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

                                @if(canDelete($recruiter, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.career.recruiter.destroy', $recruiter) !!}"
                                          method="POST">
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
                        <td colspan="6">No recruiters found.</td>
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
