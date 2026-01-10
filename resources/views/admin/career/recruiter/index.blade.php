@php
    $buttons = [];
    if (canCreate('recruiter', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recruiter', 'href' => route('admin.career.recruiter.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Recruiters',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Recruiters' ]
    ],
    'buttons'       =>$buttons,
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
                <th>coverage area</th>
                <th>location</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>coverage area</th>
                <th>location</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recruiters as $recruiter)

                <tr data-id="{{ $recruiter->id }}">
                    <td data-field="name" style="white-space: nowrap;">
                        {{ htmlspecialchars($recruiter->name ?? '') }}
                    </td>
                    <td data-field="international|national|regional|local" style="white-space: nowrap;">
                        {{ implode(', ', $recruiter->coverageAreas ?? []) }}
                    </td>
                    <td data-field="location">
                        {!!
                            formatLocation([
                                'city'    => htmlspecialchars($recruiter->city ?? ''),
                                'state'   => $recruiter->state['code'] ?? '',
                            ])
                        !!}
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{{ route('admin.career.recruiter.destroy', $recruiter->id) }}" method="POST">

                            @if(canRead($recruiter))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.recruiter.show', $recruiter->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($recruiter))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.recruiter.edit', $recruiter->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($recruiter->link))
                                @include('admin.components.link-icon', [
                                    'title'  => htmlspecialchars((!empty($recruiter->link_name) ? $recruiter->link_name : 'link') ?? ''),
                                    'href'   => $recruiter->link,
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

                            @if(canDelete($recruiter))
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
                    <td colspan="6">There are no recruiters.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recruiters->links('vendor.pagination.bulma') !!}

    </div>

@endsection
