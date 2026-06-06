@php
    use App\Models\Career\Company;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Company';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Companies';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Companies' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Company::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Company',
                                                                  'href' => route('admin.career.company.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-company', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.company.export', request()->except([ 'page' ])),
                'filename' => 'companies_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($companies->total()) }} {{ ($companies->total() === 1) ? 'company' : 'companies' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $companies->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

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
                                'name'  => 'industry',
                                'sort'  => 'industry_name|asc',
                            ])
                        </th>
                        <th>location</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($companies as $company)

                    <tr data-id="{{ $company->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $company->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $company->owner->username,
                                    'href' => route('admin.system.admin.show', $company->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {!! htmlspecialchars($company->name) !!}
                        </td>
                        <td data-field="industry.name" style="white-space: nowrap;">
                            {!! htmlspecialchars($company->industry->name ?? '') !!}
                        </td>
                        <td data-field="location" style="white-space: nowrap;">
                            {{
                                formatLocation([
                                    'city'    => htmlspecialchars($company->city),
                                    'state'   => $company->state->code ?? '',
                                ])
                            }}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($company, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.company.show', ownerParams($company, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($company, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.company.edit',
                                                          ownerParams($company, request()->input('owner_id'), $admin)
                                                   ),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($company->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($company->link_name) ? $company->link_name : 'link',
                                        'href'   => $company->link,
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

                                @if (canDelete($company, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.company.destroy', $company) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '6' : '4' }}">No companies found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $companies->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
