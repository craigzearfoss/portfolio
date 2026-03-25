@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Portfolio\Certification;

    $title    = $pageTitle ?? 'Certifications';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => 'Certifications' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Certification::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Certification', 'href' => route('admin.portfolio.certification.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $certifications->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>abbreviation</th>
                        <th>type</th>
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
                        <th>abbreviation</th>
                        <th>type</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($certifications as $certification)

                    <tr data-id="{{ $certification->id }}">
                        <td data-field="name">
                            {!! $certification->name !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $certification->abbreviation !!}
                        </td>
                        <td data-field="abbreviation">
                            {!! $certification->certificationType->name ?? '' !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $certification->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $certification->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($certification, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.certification.show', $certification),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($certification, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.certification.edit', $certification),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($certification->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($certification->link_name) ? $certification->link_name : 'link',
                                        'href'   => $certification->link,
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

                                @if(canDelete($certification, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.portfolio.certification.destroy', $certification) !!}"
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
                        <td colspan="6">No certifications found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $certifications->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
