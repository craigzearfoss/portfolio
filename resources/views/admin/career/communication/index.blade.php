@php
    use App\Models\Career\Application;use App\Models\Career\Communication;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Communication';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Communications' . (!empty($application) ? ' for ' . $application['name'] . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                      'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',   'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications', 'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Communications' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Communication::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Communication',
                                                                  'href' => route('admin.career.communication.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-communication', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.communication.export', request()->except([ 'page' ])),
                'filename' => 'communications_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($communications->total()) }} records found.</i></p>

            @if (!empty($pagination_top))
                {!! $communications->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>application</th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'type',
                                'sort'  => 'communication_type_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'subject',
                                'sort'  => 'subject|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'to',
                                'sort'  => 'application_apply_date|desc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'from',
                                'sort'  => 'from|desc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'datetime',
                                'sort'  => 'communication_datetime|desc',
                            ])
                        </th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($communications as $communication)

                    <tr data-id="{{ $communication->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $communication->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $communication->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="application_id" style="white-space: nowrap;">
                            @if (!empty($communication->application))
                                @include('admin.components.link', [
                                    'name' => $communication->application->name ,
                                    'href' => route('admin.career.application.show',
                                                    Application::find($communication->application->id)
                                              )
                                ])
                            @endif
                        </td>
                        <td data-field="communication_type_id" style="white-space: nowrap;">
                            {{ $communication->communicationType->name ?? '' }}
                        </td>
                        <td data-field="subject" style="white-space: nowrap;">
                            {{ $communication->subject }}
                        </td>
                        <td data-field="to">
                            {{ $communication->to }}
                        </td>
                        <td data-field="from">
                            {{ $communication->from }}
                        </td>
                        <td data-field="date" style="white-space: nowrap;">
                            {{ shortDateTime($communication->communication_datetime) }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($communication, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.communication.show', ownerParams($communication, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($communication, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.communication.edit', ownerParams($communication, request()->input('owner_id'), $admin)),
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

                                @if (canDelete($communication, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.communication.destroy', $communication) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '9' : '7' }}">No communications found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $communications->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
