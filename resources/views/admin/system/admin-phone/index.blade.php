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

            <p><i>{{ number_format($adminPhones->total()) }} records found.</i></p>

            @if (!empty($pagination_top))
                {!! $adminPhones->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if ($top_column_headings)
                    <thead>
                    <tr>
                        @if ($isRootAdmin)
                            <th>id</th>
                            <th>owner</th>
                        @endif
                        <th>phone</th>
                        <th>label</th>
                        <th class="has-text-centered">public</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if ($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if ($isRootAdmin)
                            <th>id</th>
                            <th>owner</th>
                        @endif
                        <th>phone</th>
                        <th>label</th>
                        <th class="has-text-centered">public</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($adminPhones as $adminPhone)

                    <tr data-id="{{ $adminPhone->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $adminPhone->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if (!empty($adminPhone->owner))
                                    @include('admin.components.link', [
                                        'name' => $adminPhone->owner->username,
                                        'href' => route('admin.system.admin.show', $adminPhone->owner)
                                    ])
                                @else
                                    ?
                                @endif
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
                            <td colspan="6">No admin phone numbers found.</td>
                        @else
                            <td colspan="4">No phone numbers found.</td>
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
