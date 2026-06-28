@php
    use App\Models\Personal\Unit;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Personal\Unit';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Units';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Units' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Unit::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Unit',
                                                                  'href' => route('admin.personal.unit.create')
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 40em !important;">

            @if (!empty($pagination_top))
                {!! $units->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the unit is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                        @endif
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'abbreviation',
                                'sort'  => 'abbreviation|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'system',
                                'sort'  => 'system|asc',
                            ])
                        </th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($units as $unit)

                    <tr data-id="{{ $unit->id }}" {!! $unit->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $unit->id ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! htmlspecialchars($unit->name) !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! htmlspecialchars($unit->abbreviation) !!}
                        </td>
                        <td data-field="system">
                            {{ $unit->system }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($unit, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.unit.show', $unit),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($unit, $admin))
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

                                @if (canDelete($unit, $admin))
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
                        <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No units found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $units->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
