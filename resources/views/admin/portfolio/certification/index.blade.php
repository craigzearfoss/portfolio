@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => 'Certifications' ]
    ];

    // set navigation buttons
    $buttons = [];
    if (canCreate('certification', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Certification', 'href' => route('admin.portfolio.certification.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Certifications',
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
            {!! $certifications->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>type</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>abbreviation</th>
                    <th>type</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($certifications as $certification)

                <tr data-id="{{ $certification->id }}">
                    <td data-field="name">
                        {!! $certification->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $certification->abbreviation !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $certification->certificationType->name ?? '' !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certification->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certification->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($certification, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.certification.show', $certification),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($certification, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.certification.edit', $certification),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($certification->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($certification->link_name) ? $certification->link_name : 'link',
                                    'href'   => $certification->link,
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

                            @if(canDelete($certification, $admin))
                                <form class="delete-resource" action="{!! route('admin.portfolio.certification.destroy', $certification) !!}" method="POST">
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
                    <td colspan="6">There are no certifications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $certifications->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
