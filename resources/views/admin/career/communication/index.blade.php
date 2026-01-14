@php
    $buttons = [];
    if (canCreate('communication', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Communication', 'href' => route('admin.career.communication.create') ];
    }
@endphp
@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Communications' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Communications' ]
        ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => $title ?? 'Communications' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs'   => $breadcrumbs,
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
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(empty($application))
                    <th>application</th>
                @endif
                <th>type</th>
                <th>subject</th>
                <th>date</th>
                <th>time</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(empty($application))
                    <th>application</th>
                @endif
                <th>type</th>
                <th>subject</th>
                <th>date</th>
                <th>time</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($communications as $communication)

                <tr data-id="{{ $communication->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $communication->owner->username }}
                        </td>
                    @endif
                    @if(empty($application))
                        <td data-field="application_id">
                            @include('admin.components.link', [
                                'name' => $communication->application->name ?? '',
                                'href' => route('admin.career.application.show', $communication->application->id)
                            ])
                        </td>
                    @endif
                    <td data-field="communication_type_id" style="white-space: nowrap;">
                        {!! $communication->communicationType->name ?? '' !!}
                    </td>
                    <td data-field="subject" style="white-space: nowrap;">
                        {!! $communication->subject !!}
                    </td>
                    <td data-field="date" style="white-space: nowrap;">
                        {{ shortDate($communication->date) }}
                    </td>
                    <td data-field="time" style="white-space: nowrap;">
                        {!! $communication->time !!}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.career.communication.destroy', $communication->id) !!}" method="POST">

                            @if(canRead($communication))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.communication.show', $communication->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($communication))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.communication.edit', $communication->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($communication->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($communication->link_name) ? $communication->link_name : 'link',
                                    'href'   => $communication->link,
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

                            @if(canDelete($communication))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                            @if(canRead($communication))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{!! route('admin.career.communication.show', $communication->id) !!}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($communication))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{!! route('admin.career.communication.edit', $communication->id) !!}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if(canDelete($communication))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    @php
                    $colspan = isRootAdmin() ? '6' : '5';
                    if (!empty($application)) $colspan = $colspan++;
                    @endphp
                    <td colspan="{{ $colspan }}">There are no communications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $communications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
