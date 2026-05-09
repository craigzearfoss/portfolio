@php
    use App\Models\Portfolio\Academy;
    use App\Models\Portfolio\Course;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Course';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Courses';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', !empty($owner) ? [ 'owner_id' => $owner->id ] : []) ];
    $breadcrumbs[] = [ 'name' => 'Courses' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Course::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Course',
                                                                  'href' => route('admin.portfolio.course.create',
                                                                                 $isRootAdmin && $owner ? ['owner_id' => $owner->id] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-course', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.course.export', request()->except([ 'page' ])),
                'filename' => 'courses_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($courses->total()) }} records found.</i></p>

            @if (!empty($pagination_top))
                {!! $courses->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured course.</p>

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
                                'name'  => 'academy',
                                'sort'  => 'academy_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'instructor',
                                'sort'  => 'instructor|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'completion date',
                                'sort'  => 'completion_date|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($courses as $course)

                    <tr data-id="{{ $course->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $course->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $course->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {{ $course->name }}{!! !empty($course->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="academy_id">
                            @if (!empty($course->academy))
                                @include('admin.components.link', [
                                    'name'   => $course->academy->name ?? '',
                                    'href'   => route('admin.portfolio.academy.show', $course->academy),
                                ])
                            @endif
                        </td>
                        <td data-field="instructor">
                            {{ $course->instructor }}
                        </td>
                        <td data-field="completion_date" class="has-text-centered">
                            {{ shortDate($course->completion_date) }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $course->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $course->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($course, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.course.show', ownerParams($course, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($course, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.course.edit', ownerParams($course, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($course->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($course->link_name) ? $course->link_name : 'link',
                                        'href'   => $course->link,
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

                                @if (canDelete($course, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.course.destroy', $course) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '9' : '7' }}">No courses found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $courses->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
