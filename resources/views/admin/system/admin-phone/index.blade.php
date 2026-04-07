@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\System\AdminPhone;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Admin Phone Numbers' : 'Phone Numbers');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index',
                                                       !empty($owner)
                                                           ? ['owner_id'=>$owner->id]
                                                           : []
                                                      )],
        [ 'name' => $isRootAdmin ? 'Admin Phone Numbers' : 'Phone Numbers' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(AdminPhone::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add Phone Number',
                                                               'href' => route('admin.system.admin-phone.create',
                                                                               $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.system-owner')
    @endif

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $adminPhones->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>phone</th>
                        <th>label</th>
                        <th class="has-text-centered">public</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
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
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @if(!empty($adminPhone->owner))
                                    @include('admin.components.link', [
                                        'name' => $adminPhone->owner->username,
                                        'href' => route('admin.system.admin.show', $adminPhone->owner)
                                    ])
                                @else
                                    ?
                                @endif
                            </td>
                        @endif
                        <td data-field="phone">
                            {!! $adminPhone->phone !!}
                        </td>
                        <td data-field="label">
                            {!! $adminPhone->label !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminPhone->is_public ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($adminPhone, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-phone.show', $adminPhone),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($adminPhone, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-phone.edit', $adminPhone),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete($adminPhone, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.system.admin-phone.destroy', $adminPhone) !!}"
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
                        @if($isRootAdmin)
                            <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No admin phone numbers found.</td>
                        @else
                            <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No phone numbers found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $adminPhones->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
