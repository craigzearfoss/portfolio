@php
    $buttons = [];
    if (canCreate('resume', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.career.resume.create') ];
    }
@endphp
@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Resumes' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Resumes' ]
        ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => $title ?? 'Resumes' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Resumes' ]
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
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>date</th>
                <th class="has-text-centered">primary</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>date</th>
                <th class="has-text-centered">primary</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($resumes as $resume)

                <tr data-id="{{ $resume->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $resume->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name" style="white-space: nowrap;">
                        {!! $resume->name !!}
                    </td>
                    <td data-field="date" style="white-space: nowrap;">
                        {{ shortDate($resume->date) }}
                    </td>
                    <td data-field="primary" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->primary ])
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $resume->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.career.resume.destroy', $resume->id) !!}" method="POST">

                            @if(canRead($resume))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.resume.show', $resume->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($resume))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.resume.edit', $resume->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($resume->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($resume->link_name) ? $resume->link_name : 'link',
                                    'href'   => $resume->link,
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

                            @if(canDelete($resume))
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
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There are no resumes.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $resumes->links('vendor.pagination.bulma') !!}

    </div>

@endsection
