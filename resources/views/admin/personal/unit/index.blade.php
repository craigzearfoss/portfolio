@php
    $buttons = [];
    if (canCreate('unit', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Unit', 'href' => route('admin.personal.unit.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Units',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Units' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>system</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>system</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($units as $unit)

                <tr data-id="{{ $unit->id }}">
                    <td data-field="name">
                        {!! $unit->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $unit->abbreviation !!}
                    </td>
                    <td data-field="system" class="has-text-centered">
                        {!! $unit->system !!}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.personal.unit.destroy', $unit->id) !!}" method="POST">

                            @if(canRead($unit))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.personal.unit.show', $unit->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($unit))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.personal.unit.edit', $unit->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($unit->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($unit->link_name) ? $unit->link_name : 'link',
                                    'href'   => $unit->link,
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

                            @if(canDelete($unit))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no units.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $units->links('vendor.pagination.bulma') !!}

    </div>

@endsection
