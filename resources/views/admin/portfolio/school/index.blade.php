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
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Schools' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(School::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New School',
                                                                  'href' => route('admin.portfolio.school.create')
                                                                ])->render();
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

            <p><i>{{ number_format($schools->total()) }} {{ ($schools->total() === 1) ? 'school' : 'schools' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $schools->links('vendor.pagination.bulma') !!}
            @endif

            <p class="is-size-7 mb-0"><i>cc - community college, hbcu -, tech - technical, med - medical, rel - religious, sem - seminary</i></p>
            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the school is disabled.</p>

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
                                'name'  => 'city',
                                'sort'  => 'city|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'state',
                                'sort'  => 'state_name|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'founded',
                                'sort'  => 'founded|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            type
                        </th>
                        <th>
                            details
                        </th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($schools as $school)

                    <tr data-id="{{ $school->id }}" {!! $school->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $school->id }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name'  => $school->name,
                                'href'  => route('admin.portfolio.school.show', $school),
                                'class' => $school->is_disabled ? [ 'disabled-text' ] : []
                            ])
                        </td>
                        <td data-field="logo_small" style="display: none;">
                            @include('admin.components.image', [
                                'src'   => $school->logo_small,
                                'alt'   => $school->name,
                                'width' => '48px',
                            ])
                        </td>
                        <td data-field="city" style="white-space: nowrap;">
                            {{ $school->city }}
                        </td>
                        <td data-field="state" style="white-space: nowrap;">
                            {{ $school->state['code'] ?? '' }}
                        </td>
                        <td data-field="founded" class="has-text-centered">
                            {{ $school->founded }}
                        </td>
                        <td data-field="type" class="has-text-centered" style="white-space: nowrap;">
                            {{ $school->type }}
                        </td>
                        <td data-field="details" style="min-width: 20rem;">
                            @include('admin.components.partials.school-details-abbreviated', [ 'school' => $school ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($school, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.school.show', $school),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($school, $admin))
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

                                @if (canDelete($school, $admin))
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
                        <td colspan="{{ $isRootAdmin ? '7' : '6' }}">No schools found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            <p class="is-size-7"><i>cc - community college, hbcu -, tech - technical, med - medical, rel - religious, sem - seminary</i></p>

            @if (!empty($pagination_bottom))
                {!! $schools->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
