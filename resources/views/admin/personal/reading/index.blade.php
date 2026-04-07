@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Personal\Reading;

    $title    = $pageTitle ?? 'Readings';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->is_root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Readings' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Reading::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Reading', 'href' => route('admin.personal.reading.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.personal-reading', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $readings->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured reading.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if(!empty($admin->is_root))
                            <th>owner</th>
                        @endif
                        <th>title</th>
                        <th>author</th>
                        <th>type</th>
                        <th class="has-text-centered">published</th>
                        <th>media</th>
                        <th class="has-text-centered">wishlist</th>
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
                        <th>author</th>
                        <th>type</th>
                        <th class="has-text-centered">published</th>
                        <th>media</th>
                        <th class="has-text-centered">wishlist</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($readings as $reading)

                    <tr data-id="{{ $reading->id }}">
                        @if($admin->is_root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $reading->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="title">
                            {!! $reading->title !!}{!! !empty($reading->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="author">
                            {!! $reading->author !!}
                        </td>
                        <td data-field="fiction|nonfiction">
                            {{
                                (!empty($reading->fiction) && !empty($reading->nonfiction))
                                    ? 'fiction/nonfiction'
                                    : (!empty($reading->fiction) ? 'fiction' : (!empty($reading->nonfiction) ? 'nonfiction' : ''))
                            }}
                        </td>
                        <td data-field="publication_year" class="has-text-centered">
                            @if($reading->publication_year < 0)
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

                                @if(canRead($reading, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.reading.show', [$owner, $reading->id]),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($reading, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.reading.edit', [$owner, $reading->id]),
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

                                @if(canDelete($reading, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.personal.reading.destroy', $reading) !!}"
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
                        <td colspan="{{ $admin->is_root ? '10' : '9' }}">No readings found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $readings->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
