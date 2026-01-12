@php
    $buttons = [];
    if (canCreate('industry', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Industry', 'href' => route('admin.career.industry.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Industries',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Industries' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbreviation</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($industries as $industry)

                <tr data-id="{{ $industry->id }}">
                    <td data-field="name" style="white-space: nowrap;">
                        {!! $industry->name !!}
                    </td>
                    <td data-field="abbreviation">
                        {!! $industry->abbreviation !!}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.career.industry.destroy', $industry->id) !!}" method="POST">

                            @if(canRead($industry))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.industry.show', $industry->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($industry))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.industry.edit', $industry->id),
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

                            @if(canDelete($industry))
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
                    <td colspan="3">There are no industries.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $industries->links('vendor.pagination.bulma') !!}

    </div>

@endsection
