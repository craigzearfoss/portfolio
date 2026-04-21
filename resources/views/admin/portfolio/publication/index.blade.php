@php
    use App\Models\Portfolio\Publication;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Publication';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Publications';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Publications' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Publication::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Publication', 'href' => route('admin.portfolio.publication.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-publication', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $publications->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured publication.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>title</th>
                        <th>publication</th>
                        <th>publisher</th>
                        <th class="has-text-centered">year</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>title</th>
                        <th>publication</th>
                        <th>publisher</th>
                        <th class="has-text-centered">year</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($publications as $publication)

                    <tr data-id="{{ $publication->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $publication->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="title">
                            {!! $publication->title !!}{!! !empty($publication->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="publication_name">
                            {!! $publication->publication_name !!}
                        </td>
                        <td data-field="publisher">
                            {!! $publication->publisher !!}
                        </td>
                        <td data-field="publication_year" class="has-text-centered">
                            {!! $publication->publication_year !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $publication->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $publication->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($publication, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.publication.show', $publication),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($publication, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.publication.edit', $publication),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($publication->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($publication->link_name) ? $publication->link_name : 'link',
                                        'href'   => $publication->link,
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

                                @if(canDelete($publication, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.portfolio.publication.destroy', $publication) !!}"
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
                        <td colspan="{{ $isRootAdmin ? '8' : '7' }}">No publications found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $publications->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
