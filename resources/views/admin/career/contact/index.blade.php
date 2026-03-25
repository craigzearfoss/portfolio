@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Career\Contact;

    $title    = $pageTitle ?? 'Contacts';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->is_root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Contacts' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Contact::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Contact', 'href' => route('admin.career.contact.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-contact',
        [ 'action'     => route('admin.career.contact.index'),
          'owner_id'   => $isRootAdmin ? null : $owner->id,
        ]
    )

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $contacts->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($admin->is_root)
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
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if(!empty($admin->is_root))
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
                        @if($admin->is_root)
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
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $contact->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $contact->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($contact, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.contact.show', $contact),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($contact, $admin))
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

                                @if(canDelete($contact, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.career.contact.destroy', $contact) !!}"
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
                        <td colspan="{{ $admin->is_root ? '8' : '7' }}">No contacts found.</td>
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
