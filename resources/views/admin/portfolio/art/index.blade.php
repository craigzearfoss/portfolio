@php
    use App\Models\Portfolio\Art;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Art';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title = $pageTitle ?? 'Art';

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    $breadcrumbs[] = [ 'name' => 'Art' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Art::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Art',
                                                                  'href' => route('admin.portfolio.art.create',
                                                                                  $isRootAdmin ? [ 'owner_id'=>$owner->id ?? null ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-art', [ 'owner_id' => $isRootAdmin ? null : $owner->id])

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 80em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.art.export', request()->except([ 'page' ])),
                'filename' => 'arts_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($arts->total()) }} {{ ($arts->total() === 1) ? 'art' : 'arts' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured art. <span class="sample-color-box-light-gray"></span> indicates the art is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}" style="width: auto;
            table-layout: auto;">

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
                                'name'  => 'artist',
                                'sort'  => 'artist|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'art_year|asc',
                            ])
                        </th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($arts as $art)

                    <tr data-id="{{ $art->id }}" {!! $art->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $art->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $art->owner->username,
                                    'href'  => route('admin.system.admin.show', $art->owner),
                                    'class' => $art->is_disabled ? [ 'disabled-text' ] : []
                                ])
                                @include('admin.components.link-icon', [
                                   'title'      => 'add to favorites',
                                   'icon'       => 'fa-heart',
                                   'border'     => false,
                                   'target'     => '_blank',
                                   'class'      => 'add-to-favorites',
                                   'attributes' => [ 'data-resource' => 'portfolio.art', 'data-id' => $art->id ]
                               ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name'  => $art->name . (!empty($art->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href'  => route('admin.portfolio.art.show', $art),
                                'class' => $art->is_disabled ? [ 'disabled-text' ] : []
                            ])
                        </td>
                        <td data-field="artist" style="white-space: nowrap;">
                            {{ $art->artist }}
                        </td>
                        <td data-field="art_year">
                            {{ $art->art_year }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $art->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $art->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($art, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.art.show', ownerParams($art, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($art, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.art.edit', ownerParams($art, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($art->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($art->link_name) ? $art->link_name : 'link',
                                        'href'   => $art->link,
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

                                @if (canDelete($art, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.art.destroy', $art) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '8' : '6' }}">No art found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
