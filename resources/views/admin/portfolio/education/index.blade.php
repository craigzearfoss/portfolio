@php
    use App\Models\Portfolio\Education;
    use Illuminate\Support\Carbon;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Education';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Education';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Education' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Education::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Education',
                                                                  'href' => route('admin.portfolio.education.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-education', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.education.export', request()->except([ 'page' ])),
                'filename' => 'educations_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($educations->total()) }} {{ ($educations->total() === 1) ? 'education' : 'educations' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $educations->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured education. <span class="sample-color-box-light-gray"></span> indicates the education is disabled.</p>

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
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'degree',
                                'sort'  => 'degree_type_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'major',
                                'sort'  => 'major|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'minor',
                                'sort'  => 'minor|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'school',
                                'sort'  => 'school_name|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'enrolled',
                                'sort'  => 'enrollment_date|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'graduated',
                                'sort'  => 'graduation_date|asc',
                            ])
                        </th>
                        <th class="has-text-centered">currently<br>enrolled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($educations as $education)

                    <tr data-id="{{ $education->id }}" {!! $education->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $education->id  }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $education->owner->username,
                                    'href'  => route('admin.system.admin.show', $education->owner),
                                    'class' => $education->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </td>
                        @endif
                        <td data-field="degreeType.name" style="white-space: nowrap;">
                            {{ $education->degreeType->name ?? '' }}
                        </td>
                        <td data-field="major" style="white-space: nowrap;">
                            {{ $education->major }}{!! !empty($education->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'portfolio.education', 'data-id' => $education->id ]
                           ])
                        </td>
                        <td data-field="minor" style="white-space: nowrap;">
                            {{ $education->minor }}
                        </td>
                        <td data-field="school.name" style="white-space: nowrap;">
                            {{ $education->school->name ?? '' }}
                        </td>
                        <td data-field="enrollment_date" class="has-text-centered" style="white-space: nowrap;">
                            {{ !empty($education->enrollment_date) ? Carbon::parse($education->enrollment_date)->format("M y") : '' }}
                        </td>
                        <td data-field="graduation_date" class="has-text-centered" style="white-space: nowrap;">
                            {{ !empty($education->graduation_date) ? Carbon::parse($education->graduation_date)->format("M y") : '' }}
                        </td>
                        <td data-field="currently_enrolled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $education->currently_enrolled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($education, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.education.show', ownerParams($education, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($education, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.education.edit', ownerParams($education, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($education->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($education->link_name) ? $education->link_name : 'link',
                                        'href'   => $education->link,
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

                                @if (canDelete($education, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.education.destroy', $education) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '10' : '8' }}">No education found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $educations->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
