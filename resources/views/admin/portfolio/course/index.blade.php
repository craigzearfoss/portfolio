@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Courses';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Courses' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'course', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Course', 'href' => route('admin.portfolio.course.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.portfolio.course.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

        @if($pagination_top)
            {!! $courses->links('vendor.pagination.bulma') !!}
        @endif

        <p class="admin-table-caption">* An asterisk indicates a featured course.</p>

        <table class="table admin-table {{ $adminTableClasses ?? '' }}">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>academy</th>
                <th class="has-text-centered">completion<br>date</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>academy</th>
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
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $course->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $course->name !!}{!! !empty($course->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                    </td>
                    <td data-field="academy.name">
                        @if (!empty($course->academy))
                            @include('admin.components.link', [
                                'name'   => $course->academy->name ?? '',
                                'href'   => route('admin.portfolio.academy.show', \App\Models\Portfolio\Academy::find($course->academy->id)),
                            ])
                        @endif
                    </td>
                    <td data-field="completion_date">
                        {{ shortDate($course->completion_date) }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $course->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $course->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(PermissionEntityTypes::RESOURCE, $course, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.course.show', $course),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(PermissionEntityTypes::RESOURCE, $course, $admin))
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

                            @if(canDelete(PermissionEntityTypes::RESOURCE, $course, $admin))
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
                    <td colspan="{{ $admin->root ? '7' : '6' }}">There are no courses.</td>
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
