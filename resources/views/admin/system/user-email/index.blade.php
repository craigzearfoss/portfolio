@php
    use App\Models\System\UserEmail;
    use Illuminate\Support\Number;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\System\UserEmail';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $user        = $user ?? null;

    $title    = $pageTitle ?? ($isRootAdmin ? 'User Email Addresses' : 'Email Addresses');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => $isRootAdmin ? 'User Email Addresses' : 'Email Addresses' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(UserEmail::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Email',
                                                               'href' => route('admin.system.user-email.create',
                                                                               $user ? [ 'user_id' => $user->id ] : []
                                                                              )
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

            <p><i>{{ Number::format($userEmails->total()) }} records found.</i></p>

            @if(!empty($pagination_top))
                {!! $userEmails->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owning user</th>
                        @endif
                        <th>email</th>
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
                            <th>owning user</th>
                        @endif
                        <th>email</th>
                        <th>label</th>
                        <th class="has-text-centered">public</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($userEmails as $userEmail)

                    <tr data-id="{{ $userEmail->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $userEmail->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="email">
                            {!! $userEmail->email !!}
                        </td>
                        <td data-field="label">
                            {!! $userEmail->label !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $userEmail->is_public ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($userEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.system.user-email.show', $userEmail),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($userEmail, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.system.user-email.edit', $userEmail),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete($userEmail, $admin))
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
                        @if($isRootAdmin)
                            <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No user email addresses found.</td>
                        @else
                            <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No email addresses found.</td>
                        @endif
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $userEmails->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
