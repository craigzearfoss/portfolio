@php
    use App\Models\Career\Contact;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Contact';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Contacts';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Contacts' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Contact::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Contact',
                                                                  'href' => route('admin.career.contact.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-contact', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.contact.export', request()->except([ 'page' ])),
                'filename' => 'contacts_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($contacts->total()) }} {{ ($contacts->total() === 1) ? 'contact' : 'contacts' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $contacts->links('vendor.pagination.bulma') !!}
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
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'company',
                                'sort'  => 'company_name|asc',
                            ])
                        </th>
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
                                'name'  => 'email',
                                'sort'  => 'email|asc',
                            ])
                        </th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($contacts as $contact)

                    <tr data-id="{{ $contact->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $contact->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $contact->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => $contact->owner->username,
                                'href' => route('admin.system.admin.show', $contact->owner)
                            ])
                        </td>
                        <td data-field="contact.company.names" style="white-space: nowrap;">
                            @php
                                $companyLinks = $contact->companies->map(
                                    function ($company) {
                                        return '<a href="' . route('admin.career.company.show', $company) . '">' . htmlspecialchars($company->name) . '</a>';
                                    }
                                );
                                echo $companyLinks->implode(', ');
                            @endphp
                        </td>
                        <td data-field="phone" style="white-space: nowrap;">
                            {!! htmlspecialchars($contact->phone) !!}
                        </td>
                        <td data-field="email" style="white-space: nowrap;">
                            {!! htmlspecialchars($contact->email) !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $contact->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $contact->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($contact, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.contact.show', ownerParams($contact, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($contact, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.contact.edit',
                                                          ownerParams($contact, request()->input('owner_id'), $admin)
                                                   ),
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

                                @if (canDelete($contact, $admin))
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
                        <td colspan="{{ $isRootAdmin ? '9' : '7' }}">No contacts found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $contacts->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
