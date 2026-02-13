@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies' ],
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'academy', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Academy', 'href' => route('admin.portfolio.academy.create', $owner ??  $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Academies',
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

    <div class="card p-4">

        @if($pagination_top)
            {!! $academies->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>name</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($academies as $academy)

                <tr data-id="{{ $academy->id }}">
                    <td data-field="name">
                        {!! $academy->name !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $academy->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $academy->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $academy, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.academy.show', $academy),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $academy, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.academy.edit', $academy),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($academy->link))
                                @include('admin.components.link-icon', [
                                    'title'  => $academy->link_name ? $academy->link_name : 'link',
                                    'href'   => $academy->link,
                                    'icon'   => 'fa-external-link',
                                    'target' => '_blank'
                                ])
                            @else
                                @include('admin.components.link-icon', [
                                    'title' => 'link',
                                    'icon'     => 'fa-external-link',
                                    'disabled' => true
                                ])
                            @endif

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $academy, $admin))
                                <form class="delete-resource" action="{!! route('admin.portfolio.academy.destroy', $academy) !!}" method="POST">
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
                    <td colspan="4">There are no academies.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $academies->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
