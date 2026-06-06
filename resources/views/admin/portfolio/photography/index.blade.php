@php
    use App\Models\Portfolio\Photography;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Photography';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Photography';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Photography' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Photography::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Photo',
                                                                   'href' => route('admin.portfolio.photography.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-photography', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <p class="admin-table-caption">* An asterisk indicates a featured photo.</p>

    <div class="floating-div-container" style="max-width: 60em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.photography.export', request()->except([ 'page' ])),
                'filename' => 'photography_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($photos->total()) }} {{ ($photos->total() === 1) ? 'photo' : 'photos' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $photos->links('vendor.pagination.bulma') !!}
            @endif

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
                                'name'  => 'credit',
                                'sort'  => 'credit|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'photo_year|asc',
                            ])
                        </th>
                        <th>public</th>
                        <th>disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($photos as $photo)

                    <tr data-id="{{ $photo->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $photo->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $photo->owner->username,
                                    'href' => route('admin.system.admin.show', $photo->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;" style="white-space: nowrap;">
                            {{ $photo->name }}{!! !empty($photo->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="credit" style="white-space: nowrap;">
                            {{ $photo->credit }}
                        </td>
                        <td data-field="photo_year" class="has-text-centered">
                            {{ $photo->photo_year }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $photo->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $photo->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($photo, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.photography.show', ownerParams($photo, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($photo, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.photography.edit', ownerParams($photo, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($photo->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($photo->link_name) ? $photo->link_name : 'link',
                                        'href'   => $photo->link,
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

                                @if (canDelete($photo, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.photography.destroy', $photo) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '8' : '6' }}">There is are no photos.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $photos->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
