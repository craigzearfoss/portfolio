@php
    use App\Models\Dictionary\Framework;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = 'Dictionary (frameworks)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Frameworks' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Framework::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Framework', 'href' => route('admin.dictionary.framework.create')])->render();
    }
@endphp

@extends('admin.layouts.default');

@section('content')

    <div class="floating-div-container" style="max-width: 50em !important;">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $frameworks->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>abbrev</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th>abbrev</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($frameworks as $framework)

                    @php
                        // don't displace the entry for "other"
                        if ($server->name == 'other') continue;
                    @endphp

                    <tr data-id="{{ $framework->id }}">
                        <td data-field="name">
                            {!! $framework->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $framework->abbreviation !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $framework->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $framework->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($framework, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.dictionary.framework.show', $framework),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($framework, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.dictionary.framework.edit', $framework),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($framework->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($framework->link_name) ? $framework->link_name : 'link',
                                        'href'   => $framework->link,
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

                                @if (!empty($framework->wikipedia))
                                    @include('admin.components.link-icon', [
                                        'title'  => 'Wikipedia page',
                                        'href'   => $framework->wikipedia,
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

                                @if(canDelete($framework, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.dictionary.framework.destroy', $framework) !!}"
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
                        <td colspan="5">No frameworks found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $frameworks->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
