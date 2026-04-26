@php
    use App\Models\Dictionary\OperatingSystem;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Dictionary\OperatingSystem';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = 'Dictionary (operating systems)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(OperatingSystem::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Operating System', 'href' => route('admin.dictionary.operating-system.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container" style="max-width: 50em !important;">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $operatingSystems->links('vendor.pagination.bulma') !!}
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

                @forelse ($operatingSystems as $operatingSystem)

                    @php
                        // don't display the entry for "other"
                        if ($operatingSystem->name == 'other') continue;
                    @endphp

                    <tr data-id="{{ $operatingSystem->id }}">
                        <td data-field="name">
                            {!! $operatingSystem->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $operatingSystem->abbreviation !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $operatingSystem->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $operatingSystem->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($operatingSystem, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.dictionary.operating-system.show', $operatingSystem),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($operatingSystem, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.dictionary.operating-system.edit', $operatingSystem),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($operatingSystem->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($operatingSystem->link_name) ? $operatingSystem->link_name : 'link',
                                        'href'   => $operatingSystem->link,
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

                                @if (!empty($operatingSystem->wikipedia))
                                    @include('admin.components.link-icon', [
                                        'title'  => 'Wikipedia page',
                                        'href'   => $operatingSystem->wikipedia,
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

                                @if(canDelete($operatingSystem, $admin))
                                    <form class="delete-resource" action="{!! route('admin.dictionary.operating-system.destroy', $operatingSystem) !!}" method="POST">
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
                        <td colspan="5">No operating systems found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $operatingSystems->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
