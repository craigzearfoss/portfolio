@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Career\Application;use App\Models\Career\Communication;

    $title    = $pageTitle ?? 'Communications' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',               'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',             'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,      'href' => route('admin.career.application.index') ],
            [ 'name' => $application['name'], 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Communications' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Communications' ]
        ];
    }

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Communication::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Communication', 'href' => route('admin.career.communication.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.career.communication.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $communications->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->is_root))
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

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->is_root))
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
                @endif

                <tbody>

                @forelse ($communications as $communication)

                    <tr data-id="{{ $communication->id }}">
                        @if($admin->is_root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $communication->owner->username }}
                            </td>
                        @endif
                        @if(empty($application))
                            <td data-field="application_id">
                                @include('admin.components.link', [
                                    'name' => $communication->application->name ?? '',
                                    'href' => route('admin.career.application.show',
                                                    Application::find($communication->application->id)
                                              )
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
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($communication, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.communication.show', $communication),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($communication, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.communication.edit', $communication),
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

                                @if(canRead($communication, $admin))
                                    <a title="show" class="button is-small px-1 py-0"
                                       href="{!! route('admin.career.communication.show', $communication) !!}">
                                        <i class="fa-solid fa-list"></i>
                                    </a>
                                @endif

                                @if(canUpdate($communication, $admin))
                                    <a title="edit" class="button is-small px-1 py-0"
                                       href="{!! route('admin.career.communication.edit', $communication) !!}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endif

                                @if(canDelete($communication, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.career.communication.destroy', $communication) !!}"
                                          method="POST">
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
                        @php
                            $colspan = $admin->is_root ? '6' : '5';
                            if (!empty($application)) $colspan = $colspan++;
                        @endphp
                        <td colspan="{{ $colspan }}">There are no communications.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $communications->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
