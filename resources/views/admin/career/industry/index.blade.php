@php
    $buttons = [];
    if (canCreate('industry', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Event', 'href' => route('admin.career.industry.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Industries',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Industries' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'loggedInAdmin'    => $loggedInAdmin,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        @if($pagination_top)
            {!! $industries->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>abbreviation</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($industries as $industry)

                <tr data-id="{{ $industry->id }}">
                    <td data-field="name" style="white-space: nowrap;">
                        {!! $industry->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $industry->abbreviation !!}
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($industry, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.industry.show', $industry),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($industry, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.industry.edit', $industry),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($industry->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($industry->link_name) ? $industry->link_name : 'link',
                                    'href'   => $industry->link,
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

                            @if(canDelete($industry, $admin))
                                <form class="delete-resource" action="{!! route('admin.career.industry.destroy', $industry) !!}" method="POST">
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
                    <td colspan="3">There are no industries.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $industries->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
