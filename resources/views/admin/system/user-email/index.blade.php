@php
    use App\Models\System\UserEmail;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\UserEmail';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $user        = $user ?? null;

    $title    = $pageTitle ?? ($isRootAdmin ? 'User Emails' : 'Emails');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Emails' : 'Emails' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(UserEmail::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Email',
                                                                  'href' => route('admin.system.user-email.create', !empty($user) ? [ 'user_id' => $user->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-user-email')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.user-email.export', request()->except([ 'page' ])),
                'filename' => 'user_emails_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($userEmails->total()) }} {{ $isRootAdmin ? 'user ' : '' }}{{ ($allUsers->total() === 1) ? 'email' : 'emails' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $userEmails->links('vendor.pagination.bulma') !!}
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
                                    'name'  => 'user',
                                    'sort'  => 'user_username|asc',
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

                @forelse ($userEmails as $userEmail)

                    <tr data-id="{{ $userEmail->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $userEmail->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $userEmail->$userTeam->username,
                                    'href' => route('admin.system.admin.show', $userEmail->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="email" style="white-space: nowrap;">
                            {{ $userEmail->email }}
                        </td>
                        <td data-field="label" style="white-space: nowrap;">
                            {{ $userEmail->label }}
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userEmail->is_disabled ])
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userEmail->is_public ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($userEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-email.show', $userEmail),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($userEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.user-email.edit', $userEmail),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (canDelete($userEmail, $admin))
                                    <form class="delete-resource" action="{!! route('admin.system.user-email.destroy', $userEmail) !!}" method="POST">
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
                            <td colspan="7">No user email addresses found.</td>
                        @else
                            <td colspan="5">No email addresses found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $userEmails->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
