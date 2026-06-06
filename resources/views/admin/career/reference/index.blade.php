@php
    use App\Models\Career\Reference;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Reference';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'References';
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
    $breadcrumbs[] = [ 'name' => 'References' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Reference::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Reference',
                                                                  'href' => route('admin.career.reference.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-reference', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.reference.export', request()->except([ 'page' ])),
                'filename' => 'references_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($references->total()) }} {{ ($references->total() === 1) ? 'reference' : 'references' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $references->links('vendor.pagination.bulma') !!}
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
                        <th>relation</th>
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
                        <th>location</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($references as $reference)

                    <tr data-id="{{ $reference->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $reference->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $reference->owner->username,
                                    'href' => route('admin.system.admin.show', $reference->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {!! htmlspecialchars($reference->name) !!}
                        </td>
                        <td data-field="relation" style="white-space: nowrap;">
                            {{ $reference->relation }}
                        </td>
                        <td data-field="phone" style="white-space: nowrap;">
                            {!! htmlspecialchars($reference->phone) !!}
                        </td>
                        <td data-field="email" style="white-space: nowrap;">
                            {!! htmlspecialchars($reference->email) !!}
                        </td>
                        <td data-field="location" style="white-space: nowrap;">
                            {{
                                formatLocation([
                                    'city'    => htmlspecialchars($reference->city),
                                    'state'   => $reference->state->code ?? '',
                                ])
                            }}
                        </td>
                        <td data-field="is_public" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $reference->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $reference->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($reference, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.reference.show', ownerParams($reference, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($reference, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.reference.edit', ownerParams($reference, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($reference->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($reference->link_name) ? $reference->link_name : 'link',
                                        'href'   => $reference->link,
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

                                @if (canDelete($reference, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.reference.destroy', $reference) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '10' : '8' }}">No references found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $references->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
