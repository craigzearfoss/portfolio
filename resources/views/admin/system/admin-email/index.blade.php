@php
    use App\Models\System\AdminEmail;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\AdminEmail';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? ($isRootAdmin ? 'Admin Emails' : 'Emails');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'Admin Emails' : 'Emails' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(AdminEmail::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Email',
                                                                  'href' => route('admin.system.admin-email.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-admin-email')

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 80em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.admin-email.export', request()->except([ 'page' ])),
                'filename' => 'admin_emails_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($adminEmails->total()) }} {{ $isRootAdmin ? 'admin ' : '' }}{{ ($adminEmails->total() === 1) ? 'email' : 'emails' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $adminEmails->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the admin email is disabled.</p>

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
                                'name'  => 'email',
                                'sort'  => 'email|asc',
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

                @forelse ($adminEmails as $adminEmail)

                    <tr data-id="{{ $adminEmail->id }}" {!! $adminEmail->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $adminEmail->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $adminEmail->owner->username,
                                    'href' => route('admin.system.admin.show', $adminEmail->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="email" style="white-space: nowrap;">
                            {{ $adminEmail->email }}
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'system.admin_email', 'data-id' => $adminEmail->id ]
                           ])
                        </td>
                        <td data-field="label" style="white-space: nowrap;">
                            {{ $adminEmail->label }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminEmail->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $adminEmail->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($adminEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.admin-email.show', ownerParams($adminEmail, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($adminEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.admin-email.edit', ownerParams($adminEmail, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (canDelete($adminEmail, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.admin-email.destroy', $adminEmail) !!}" method="POST">
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
                            <td colspan="7">No admin email addresses found.</td>
                        @else
                            <td colspan="5">No email addresses found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $adminEmails->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
