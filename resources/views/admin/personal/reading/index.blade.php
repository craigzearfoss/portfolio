@php
    use App\Models\Personal\Reading;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Personal\Reading';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Readings';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Readings' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Reading::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Reading',
                                                                  'href' => route('admin.personal.reading.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.personal-reading', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.personal.reading.export', request()->except([ 'page' ])),
                'filename' => 'readings_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($readings->total()) }} {{ ($readings->total() === 1) ? 'reading' : 'readings' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $readings->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured reading.</p>

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
                                'name'  => 'title',
                                'sort'  => 'title|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'author',
                                'sort'  => 'author|asc',
                            ])
                        </th>
                        <th>type</th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'published',
                                'sort'  => 'publication_year|asc',
                            ])
                        </th>
                        <th>media</th>
                        <th class="has-text-centered">wishlist</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                        </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($readings as $reading)

                    <tr data-id="{{ $reading->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $reading->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $reading->owner->username,
                                    'href' => route('admin.system.admin.show', $reading->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="title" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => $reading->title . (!empty($reading->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href' => route('admin.personal.reading.show', $reading)
                            ])
                        </td>
                        <td data-field="author" style="white-space: nowrap;">
                            {!! htmlspecialchars($reading->author) !!}
                        </td>
                        <td data-field="fiction|nonfiction">
                            {{
                                (!empty($reading->fiction) && !empty($reading->nonfiction))
                                    ? 'fiction/nonfiction'
                                    : (!empty($reading->fiction) ? 'fiction' : (!empty($reading->nonfiction) ? 'nonfiction' : ''))
                            }}
                        </td>
                        <td data-field="publication_year" class="has-text-centered">
                            @if ($reading->publication_year < 0)
                                {{ abs($reading->publication_year) }} BCE
                            @else
                                {{ $reading->publication_year }}
                            @endif
                        </td>
                        <td data-field="paper|audio" style="white-space: nowrap;">
                            {{
                                (!empty($reading->paper) && !empty($reading->audio))
                                    ? 'paper, audio'
                                    : (!empty($reading->paper) ? 'paper' : (!empty($reading->audio) ? 'audio' : ''))
                            }}
                        </td>
                        <td data-field="wishlist" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $reading->wishlist ])
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $reading->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $reading->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($reading, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.reading.show', ownerParams($reading, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($reading, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.reading.edit', ownerParams($reading, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($reading->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($reading->link_name) ? $reading->link_name : 'link',
                                        'href'   => $reading->link,
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

                                @if (canDelete($reading, $admin))
                                    <form class="delete-resource" action="{!! route('admin.personal.reading.destroy', $reading) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '11' : '9' }}">No readings found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $readings->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
