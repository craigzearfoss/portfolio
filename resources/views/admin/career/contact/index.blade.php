@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Contacts';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Contacts' ];

    // set navigation buttons
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'contact', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Contact', 'href' => route('admin.career.contact.create', $owner ?? $admin)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => $title,
    'subtitle'      => $subtitle,
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'menuService'   => $menuService,
    'admin'         => $admin,
    'user'          => $user,
    'owner'         => $owner,
])

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.career.contact.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $contacts->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if($admin->root)
                        <th>owner</th>
                    @endif
                    <th>name</th>
                    <th>company</th>
                    <th>phone</th>
                    <th>email</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>company</th>
                        <th>phone</th>
                        <th>email</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($contacts as $contact)

                    <tr data-id="{{ $contact->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $contact->owner->username }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $contact->name !!}
                        </td>
                        <td data-field="contact.company.names" style="white-space: nowrap;">
                            @php
                                $companyLinks = $contact->companies->map(
                                    function ($company) {
                                        return '<a href="' . route('admin.career.company.show', $company) . '">' . $company->name . '</a>';
                                    }
                                );
                            @endphp
                            {!! $companyLinks->implode(', ') !!}
                        </td>
                        <td data-field="phone" style="white-space: nowrap;">
                            {!! $contact->phone !!}
                        </td>
                        <td data-field="email" style="white-space: nowrap;">
                            {!! $contact->email !!}
                        </td>
                        <td data-field="public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $contact->public ])
                        </td>
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $contact->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $contact, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.contact.show', $contact),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $contact, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.contact.edit', $contact),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($contact->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($contact->link_name) ? $contact->link_name : 'link',
                                        'href'   => $contact->link,
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $contact, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.contact.destroy', $contact) !!}" method="POST">
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
                        <td colspan="{{ $admin->root ? '8' : '7' }}">There are no contacts.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $contacts->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
