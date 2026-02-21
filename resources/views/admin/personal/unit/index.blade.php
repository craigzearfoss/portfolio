@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Units';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => 'Units' ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'unit', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Unit', 'href' => route('admin.personal.unit.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
])

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $units->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    <th>name</th>
                    <th>abbreviation</th>
                    <th>system</th>
                    <th>actions</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>abbreviation</th>
                        <th>system</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($units as $unit)

                    <tr data-id="{{ $unit->id }}">
                        <td data-field="name">
                            {!! $unit->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $unit->abbreviation !!}
                        </td>
                        <td data-field="system" class="has-text-centered">
                            {!! $unit->system !!}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $unit, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.unit.show', $unit),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $unit, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.unit.edit', $unit),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($unit->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($unit->link_name) ? $unit->link_name : 'link',
                                        'href'   => $unit->link,
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $unit, $admin))
                                    <form class="delete-resource" action="{!! route('admin.personal.unit.destroy', $unit) !!}" method="POST">
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
                        <td colspan="4">There are no units.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $units->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
