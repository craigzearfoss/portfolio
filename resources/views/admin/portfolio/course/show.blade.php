@php
    use App\Enums\PermissionEntityTypes;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Courses',    'href' => route('admin.portfolio.course.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Courses',    'href' => route('admin.portfolio.course.index') ];
    }
    $breadcrumbs[] = [ 'name' => $course->name ];

    // set navigation buttons
    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $course, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.course.edit', $course)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'course', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Course', 'href' => route('admin.portfolio.course.create', $owner ?? $admin)])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.course.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Course: ' . $course->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $course->id
            ])

            @if($admin->root)
                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $course->owner->username
                ])
            @endif

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $course->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $course->slug
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'featured',
                'checked' => $course->featured
            ])

            @include('admin.components.show-row', [
                'name'  => 'summary',
                'value' => $course->summary
            ])

            @include('admin.components.show-row', [
                'name'  => 'year',
                'value' => $course->year
            ])

            @include('admin.components.show-row-checkbox', [
                'name'    => 'completed',
                'checked' => $course->completed
            ])

            @include('admin.components.show-row', [
                'name'  => 'completion date',
                'value' => longDate($course->completion_date)
            ])

            @include('admin.components.show-row', [
                'name'  => 'duration hours',
                'value' => $course->duration_hours
            ])

            @include('admin.components.show-row', [
                'name' => 'academy',
                'value' => view('admin.components.link', [
                    'name' => $course->academy['name'] ?? '',
                    'href' => !empty($course->academy)
                                    ? route('admin.portfolio.academy.show', $course->academy)
                                    : ''
                                ])
            ])

            @include('admin.components.show-row', [
                'name'  => 'school',
                'value' => $course->school
            ])

            @include('admin.components.show-row', [
                'name'  => 'instructor',
                'value' => $course->instructor
            ])

            @include('admin.components.show-row', [
                'name'  => 'sponsor',
                'value' => $course->sponsor
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $course->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => !empty($course->link_name) ? $course->link_name : 'link',
                'href'   => $course->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $course->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'disclaimer',
                'value' => view('admin.components.disclaimer', [
                                'value' => $course->disclaimer
                           ])
            ])

            @include('admin.components.show-row-images', [
                'resource' => $course,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $course,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($course->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($course->updated_at)
            ])

        </div>
    </div>

@endsection
