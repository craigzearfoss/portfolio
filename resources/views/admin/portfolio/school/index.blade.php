@php
    use App\Models\Portfolio\School;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\School';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Schools';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index', $owner ? ['owner_id' => $owner->id] : []) ],
        [ 'name' => 'Schools' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(School::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New School', 'href' => route('admin.portfolio.school.create')])->render();
    }
@endphp
@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-school')

    <div class="floating-div-container" style="max-width: 60em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.school.export', request()->except([ 'page' ])),
                'filename' => 'schools_' . date("Y-m-d-His") . '.xlsx',
            ])

            @if($pagination_top)
                {!! $schools->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th style="display: none;">logo</th>
                        <th>state</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th style="display: none;">logo</th>
                        <th>state</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($schools as $school)

                    <tr data-id="{{ $school->id }}">
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $school->name !!}
                        </td>
                        <td data-field="logo_small" style="display: none;">
                            @include('admin.components.image', [
                                'src'   => $school->logo_small,
                                'alt'   => $school->name,
                                'width' => '48px',
                            ])
                        </td>
                        <td data-field="state" style="white-space: nowrap;">
                            {{ $school->state_name }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($school, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.school.show', $school),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($school, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.school.edit', $school),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($school->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($school->link_name) ? $school->link_name : 'link',
                                        'href'   => $school->link,
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

                                @if(canDelete($school, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.school.destroy', $school) !!}" method="POST">
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
                        <td colspan="4">No schools found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $schools->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
