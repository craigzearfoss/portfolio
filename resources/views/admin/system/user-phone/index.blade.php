@php
    use App\Models\System\AdminEmail;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\UserPhone';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $user        = $user ?? null;

    $title    = $pageTitle ?? ($isRootAdmin ? 'User Phones' : 'Phones');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Phones' : 'Phones' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(AdminEmail::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add Phone',
                                                                   'href' => route('admin.system.user-phone.create', !empty($user) ? [ 'user_id' => $user->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-user-phone')

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 80em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.user-phone.export', request()->except([ 'page' ])),
                'filename' => 'user_phones_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($userPhones->total()) }} {{ $isRootAdmin ? 'user ' : '' }}{{ ($userPhones->total() === 1) ? 'phone' : 'phones' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $userPhones->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the user phone is disabled.</p>

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
                                    'name'  => 'user',
                                    'sort'  => 'user_username|asc',
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

                @forelse ($userPhones as $userPhone)

                    <tr data-id="{{ $userPhone->id }}" {!! $userPhone->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $userPhone->id }}
                            </td>
                            <td data-field="user.username" style="white-space: nowrap;">
                                {{ $userPhone->user->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="phone" style="white-space: nowrap;">
                            {{ $userPhone->phone }}
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'system.user_phone', 'data-id' => $userPhone->id ]
                           ])
                        </td>
                        <td data-field="label" style="white-space: nowrap;">
                            {{ $userPhone->label }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userPhone->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userPhone->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($userPhone, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-phone.show', $userPhone),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($userPhone, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.user-phone.edit', $userPhone),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (canDelete($userPhone, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.user-phone.destroy', $userPhone) !!}" method="POST">
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
                            <td colspan="7">No user phone numbers found.</td>
                        @else
                            <td colspan="5">No phone numbers found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $userPhones->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
