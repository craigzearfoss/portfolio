@php
    use App\Models\Portfolio\Art;
    use Illuminate\Support\Number;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Art';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Art';

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index',
                                                                    !empty($owner) ? [ 'owner_id'=>$owner->id ] : []
                                                                   )];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Art' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Art::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Art',
                                                                  'href' => route('admin.portfolio.art.create',
                                                                                  !empty($owner) ? [ 'owner_id'=>$owner->id ] : []
                                                                                 )])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-art', [ 'owner_id' => $isRootAdmin ? null : $owner->id])

    <div class="floating-div-container" style="max-width: 60em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.art.export', request()->except([ 'page' ])),
                'filename' => 'arts_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ Number::format($arts->total()) }} records found.</i></p>

            @if(!empty($pagination_top))
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates featured art.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>
                            @include('admin.components.column-heading', [ 'name' => 'name', 'class' => $className ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [ 'name' => 'artist', 'class' => $className ])
                        </th>
                        <th>
                            @include('admin.components.column-heading', [ 'name' => 'year', 'class' => $className ])
                        </th>
                        <th class="has-text-centered">
                            @include('admin.components.column-heading', [ 'name' => 'public', 'class' => $className ])
                        </th>
                        <th class="has-text-centered">
                            @include('admin.components.column-heading', [ 'name' => 'disabled', 'class' => $className ])
                        </th>
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
                        <th>name</th>
                        <th>artist</th>
                        <th>year</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($arts as $art)

                    <tr data-id="{{ $art->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $art->owner->username }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $art->name !!}{!! !empty($art->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="artist">
                            {!! $art->artist !!}
                        </td>
                        <td data-field="art_year">
                            {!! $art->art_year !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $art->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $art->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($art, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.art.show', $art),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($art, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.art.edit', $art),
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

                                @if(canDelete($art, $admin))
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
                        <td colspan="{{ $isRootAdmin ? '7' : '6' }}">No art found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $arts->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
