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
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Education' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'education', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Education', 'href' => route('admin.portfolio.education.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Education',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.portfolio.education.index') ])
    @endif

    <div class="card p-4">

        @if($pagination_top)
            {!! $educations->links('vendor.pagination.bulma') !!}
        @endif

        <p class="admin-table-caption">* An asterisk indicates a featured education.</p>
        <table class="table admin-table">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th class="has-text-centered">degree<br>type</th>
                <th>major</th>
                <th>minor</th>
                <th>school</th>
                <th class="has-text-centered">enrollment<br>date</th>
                <th>graduated</th>
                <th class="has-text-centered">graduation<br>date</th>
                <th class="has-text-centered">currently<br>enrolled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th class="has-text-centered">degree<br>type</th>
                    <th>major</th>
                    <th>minor</th>
                    <th>school</th>
                    <th class="has-text-centered">enrollment<br>date</th>
                    <th>graduated</th>
                    <th class="has-text-centered">graduation<br>date</th>
                    <th class="has-text-centered">currently<br>enrolled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($educations as $education)

                <tr data-id="{{ $education->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $education->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="degreeType.name">
                        {!! $education->degreeType->name ?? '' !!}
                    </td>
                    <td data-field="major">
                        {!! $education->major !!}{!! !empty($education->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                    </td>
                    <td data-field="minor">
                        {!! $education->minor !!}
                    </td>
                    <td data-field="school.name">
                        {!! $education->school->name ?? '' !!}
                    </td>
                    <td data-field="enrollment_month|enrollment_year" class="has-text-centered">
                        {!! $education->enrollment_year !!}
                    </td>
                    <td data-field="graduated" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->graduated ])
                    </td>
                    <td data-field="graduation_month|graduation_year" class="has-text-centered">
                        {!! $education->graduation_year !!}
                    </td>
                    <td data-field="currently_enrolled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->currently_enrolled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(PermissionEntityTypes::RESOURCE, $education, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.education.show', $education),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(PermissionEntityTypes::RESOURCE, $education, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.education.edit', $education),
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

                            @if(canDelete(PermissionEntityTypes::RESOURCE, $education, $admin))
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
                    <td colspan="{{ $admin->root ? '10' : '9' }}">There is no education.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $educations->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
