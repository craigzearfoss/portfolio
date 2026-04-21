@php
    use App\Models\Dictionary\Stack;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Dictionary\Stack';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $stack       = $stack ?? null;

    $title    = 'Dictionary (stacks)';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Stacks' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Stack::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Stack', 'href' => route('admin.dictionary.stack.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container" style="max-width: 50em !important;">

        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $stacks->links('vendor.pagination.bulma') !!}
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

                @forelse ($stacks as $stack)

                    @php
                        // don't displace the entry for "other"
                        if ($stack->name == 'other') continue;
                    @endphp

                    <tr data-id="{{ $stack->id }}">
                        <td data-field="name">
                            {!! $stack->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $stack->abbreviation !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $stack->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $stack->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($stack, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.dictionary.stack.show', $stack),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($stack, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.dictionary.stack.edit', $stack),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($stack->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($stack->link_name) ? $stack->link_name : 'link',
                                        'href'   => $stack->link,
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

                                @if (!empty($stack->wikipedia))
                                    @include('admin.components.link-icon', [
                                        'title'  => 'Wikipedia page',
                                        'href'   => $stack->wikipedia,
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

                                @if(canDelete($stack, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.dictionary.stack.destroy', $stack) !!}"
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
                        <td colspan="5">No stacks found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $stacks->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
