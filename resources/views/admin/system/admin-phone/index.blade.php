@php
    use App\Models\System\AdminPhone;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\AdminPhone';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Admin Phones' : 'Phones');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Phones' : 'Phones' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(AdminPhone::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add Phone',
                                                                  'href' => route('admin.system.admin-phone.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-admin-phone')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.admin-phone.export', request()->except([ 'page' ])),
                'filename' => 'admin_phones_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($adminPhones->total()) }} {{ $isRootAdmin ? 'admin ' : '' }}{{ ($adminPhones->total() === 1) ? 'phone' : 'phones' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $adminPhones->links('vendor.pagination.bulma') !!}
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
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'phone',
                                'sort'  => 'phone|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'label',
                                'sort'  => 'label|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($adminPhones as $adminPhone)

                    <tr data-id="{{ $adminPhone->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $adminPhone->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $adminPhone->$userTeam->username,
                                    'href' => route('admin.system.admin.show', $adminPhone->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="phone" style="white-space: nowrap;">
                            {{ $adminPhone->phone }}
                        </td>
                        <td data-field="label" style="white-space: nowrap;">
                            {{ $adminPhone->label }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminPhone->is_public ])
                        </td>
                            <td data-field="is_disabled" class="has-text-centered">
                                @include('admin.components.checkmark', [ 'checked' => $adminPhone->is_disabled ])
                            </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($adminPhone, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-phone.show', ownerParams($adminPhone, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($adminPhone, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-phone.edit', ownerParams($adminPhone, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (canDelete($adminPhone, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.admin-phone.destroy', $adminPhone) !!}" method="POST">
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
                        @if ($isRootAdmin)
                            <td colspan="7">No admin phone numbers found.</td>
                        @else
                            <td colspan="5">No phone numbers found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $adminPhones->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
