@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Companies' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate('company', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Company', 'href' => route('admin.career.company.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Companies',
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
            {!! $companies->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if($admin->root)
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>industry</th>
                <th>location</th>
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
                    <th>industry</th>
                    <th>location</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($companies as $company)

                <tr data-id="{{ $company->id }}">
                    @if(!empty($admin->root))
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $company->owner->username }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $company->name !!}
                    </td>
                        <td data-field="industry.name">
                            {!! $company->industry->name ?? '' !!}
                        </td>
                    <td data-field="location" style="white-space: nowrap;">
                        {!!
                            formatLocation([
                                'city'    => $company->city,
                                'state'   => $company->state->code ?? '',
                            ])
                        !!}
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($company, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.company.show', $company),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($company, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.company.edit', $company),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($company->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($company->link_name) ? $company->link_name : 'link',
                                    'href'   => $company->link,
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

                            @if(canDelete($company, $admin))
                                <form class="delete-resource" action="{!! route('admin.career.company.destroy', $company) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '5' : '4' }}">There are no companies.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $companies->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
