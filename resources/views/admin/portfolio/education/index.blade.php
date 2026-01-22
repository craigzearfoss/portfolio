@php
    $buttons = [];
    if (canCreate('education', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Education', 'href' => route('admin.portfolio.education.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Education',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Education' ],
    ],
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

    <div class="card p-4">

        @if($pagination_top)
            {!! $educations->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>degree<br>type</th>
                <th>major</th>
                <th>minor</th>
                <th>school</th>
                <th>enrollment<br>date</th>
                <th>graduated</th>
                <th>graduation<br>date</th>
                <th>currently<br>enrolled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    <th>degree<br>type</th>
                    <th>major</th>
                    <th>minor</th>
                    <th>school</th>
                    <th>enrollment<br>date</th>
                    <th>graduated</th>
                    <th>graduation<br>date</th>
                    <th>currently<br>enrolled</th>
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
                        {!! $education->major !!}
                    </td>
                    <td data-field="minor">
                        {!! $education->minor !!}
                    </td>
                    <td data-field="school.name">
                        {!! $education->school->name ?? '' !!}
                    </td>
                    <td data-field="enrollment_month|enrollment_year">
                        {!! $education->enrollment_year !!}
                    </td>
                    <td data-field="graduated" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->graduated ])
                    </td>
                    <td data-field="graduation_month|graduation_year">
                        {!! $education->graduation_year !!}
                    </td>
                    <td data-field="currently_enrolled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->currently_enrolled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($education, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.education.show', $education),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($education, $admin))
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

                            @if(canDelete($education, $admin))
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
