@php
    use App\Models\Portfolio\Music;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Music';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title = $pageTitle ?? 'Music';
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
    $breadcrumbs[] = [ 'name' => 'Music' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Music::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Music',
                                                                  'href' => route('admin.portfolio.music.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-music', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.music.export', request()->except([ 'page' ])),
                'filename' => 'musics_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($musics->total()) }} {{ ($musics->total() === 1) ? 'music' : 'musics' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $musics->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured music.</p>

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
                                'name'  => 'artist',
                                'sort'  => 'artist|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'year',
                                'sort'  => 'music_year|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'label',
                                'sort'  => 'label|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'cat#',
                                'sort'  => 'catalog_number|asc',
                            ])
                        </th>
                        <th>public</th>
                        <th>disabled</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($musics as $music)

                    <tr data-id="{{ $music->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $music->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $music->owner->username,
                                    'href' => route('admin.system.admin.show', $music->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => $music->name . (!empty($music->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href' => route('admin.portfolio.music.show', $music)
                            ])
                        </td>
                        <td data-field="artist" style="white-space: nowrap;">
                            {{ $music->artist }}
                        </td>
                        <td data-field="music_year" class="hide-at-900" class="has-text-centered">
                            {{ $music->music_year }}
                        </td>
                        <td data-field="label" class="hide-at-750" style="white-space: nowrap;">
                            {{ $music->label }}
                        </td>
                        <td data-field="catalog_number" class="hide-at-900" style="white-space: nowrap;">
                            {{ $music->catalog_number }}
                        </td>
                        <td data-field="is_public" class="has-text-centered hide-at-1024">
                            @include('admin.components.checkmark', [ 'checked' => $music->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered hide-at-1024">
                            @include('admin.components.checkmark', [ 'checked' => $music->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($music, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.music.show', ownerParams($music, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($music, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.music.edit', ownerParams($music, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($music->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($music->link_name) ? $music->link_name : 'link',
                                        'href'   => $music->link,
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

                                @if (canDelete($music, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.music.destroy', $music) !!}" method="POST">
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
                        <td colspan="{{$isRootAdmin ? '10' : '8' }}">No music found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $musics->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
