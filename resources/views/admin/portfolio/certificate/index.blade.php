@php
    use App\Enums\PermissionEntityTypes;
    use App\Models\Portfolio\Certificate;

    $title    = $pageTitle ?? 'Certificates';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->is_root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Certificates' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Certificate::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Certificate', 'href' => route('admin.portfolio.certificate.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-certificate', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $certificates->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured certificate.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if(!empty($admin->is_root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>academy</th>
                        <th>year</th>
                        <th>received</th>
                        <th>expiration</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->is_root))
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>academy</th>
                        <th>year</th>
                        <th>received</th>
                        <th>expiration</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($certificates as $certificate)

                    <tr data-id="{{ $certificate->id }}">
                        @if($admin->is_root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $certificate->owner->username }}
                            </td>
                        @endif
                        <td data-field="name">
                            {!! $certificate->name !!}{!! !empty($certificate->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="academy.name">
                            @if (!empty($certificate->academy))
                                @include('admin.components.link', [
                                    'name'   => $certificate->academy->name,
                                    'href'   => route('admin.portfolio.academy.show', \App\Models\Portfolio\Academy::find($certificate->academy->id)),
                                ])
                            @endif
                        </td>
                        <td data-field="year">
                            {!! $certificate->year !!}
                        </td>
                        <td data-field="received">
                            {{ shortDate($certificate->received) }}
                        </td>
                        <td data-field="expiration">
                            {{ shortDate($certificate->expiration) }}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $certificate->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $certificate->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($certificate, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.certificate.show', $certificate),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($certificate, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.certificate.edit', [$admin, $certificate]),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($certificate->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($certificate->link_name) ? $certificate->link_name : 'link',
                                        'href'   => $certificate->link,
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

                                @if(canDelete($certificate, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.portfolio.certificate.destroy', $certificate) !!}"
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
                        <td colspan="{{ $admin->is_root ? '9' : '8' }}">No certificates found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $certificates->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
