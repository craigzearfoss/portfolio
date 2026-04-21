@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Dictionary\Library';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    use App\Models\Dictionary\Library;

    $title    = 'Dictionary (libraries)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Libraries' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Library::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Library', 'href' => route('admin.dictionary.library.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container" style="max-width: 50em !important;">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $libraries->links('vendor.pagination.bulma') !!}
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

                @forelse ($libraries as $library)

                    @php
                        // don't displace the entry for "other"
                        if ($library->name == 'other') continue;
                    @endphp

                    <tr data-id="{{ $library->id }}">
                        <td data-field="name">
                            {!! $library->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $library->abbreviation !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $library->is_public ])
                        </td>
                        <td data-field="is_disabled" class="py-0 has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $library->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($library, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.dictionary.library.show', $library),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($library, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.dictionary.library.edit', $library),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($library->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($library->link_name) ? $library->link_name : 'link',
                                        'href'   => $library->link,
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

                                @if (!empty($library->wikipedia))
                                    @include('admin.components.link-icon', [
                                        'title'  => 'Wikipedia page',
                                        'href'   => $library->wikipedia,
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

                                @if(canDelete($library, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.dictionary.library.destroy', $library) !!}"
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
                        <td colspan="5">No libraries found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $libraries->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
