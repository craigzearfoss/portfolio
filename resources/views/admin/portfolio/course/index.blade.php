@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Portfolio\Academy;
    use App\Models\Portfolio\Course;

    $title    = $pageTitle ?? 'Courses';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin && !empty($owner)) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id' => $owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Courses' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Course::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Course',
                                                                 'href' => route('admin.portfolio.course.create',
                                                                                 $isRootAdmin && $owner ? ['owner_id' => $owner->id] : []
                                                                                )
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-course',
        [ 'action'     => route('admin.portfolio.course.index'),
          'owner_id'   => $isRootAdmin ? null : $owner->id,
        ]
    )

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $courses->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured course.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>academy</th>
                        <th>instructor</th>
                        <th class="has-text-centered">completion<br>date</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>academy</th>
                        <th>instructor</th>
                        <th class="has-text-centered">completion<br>date</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($courses as $course)

                    <tr data-id="{{ $course->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $course->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $course->name !!}{!! !empty($course->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="academy_id">
                            @if (!empty($course->academy))
                                @include('admin.components.link', [
                                    'name'   => $course->academy->name ?? '',
                                    'href'   => route('admin.portfolio.academy.show', Academy::find($course->academy->id)),
                                ])
                            @endif
                        </td>
                        <td data-field="instructor">
                            {{ $course->instructor }}
                        </td>
                        <td data-field="completion_date">
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

                                @if(canRead($course, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.course.show', $course),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($course, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.course.edit', [$admin, $course]),
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

                                @if(canDelete($course, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.portfolio.course.destroy', $course) !!}"
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
                        <td colspan="{{ $isRootAdmin ? '8' : '7' }}">No courses found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $courses->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
