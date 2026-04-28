@php
    use App\Models\Career\Company;
    use Illuminate\Support\Number;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Company';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Companies';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && $isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Companies' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Company::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Company', 'href' => route('admin.career.company.create', $owner ?? $admin)])->render();
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

            <p><i>{{ Number::format($companies->total()) }} records found.</i></p>

            @if(!empty($pagination_top))
                {!! $companies->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th>industry</th>
                        <th>location</th>
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
                        <th>industry</th>
                        <th>location</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($companies as $company)

                    <tr data-id="{{ $company->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $company->owner->username }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $company->name !!}
                        </td>
                        <td data-field="industry.name" style="white-space: nowrap;">
                            {!! $company->industry->name ?? '' !!}
                        </td>
                        <td data-field="location" style="white-space: nowrap;">
                            {!!
                                formatLocation([
                                    'city'    => $company->city,
                                    'state'   => $company->state->code ?? '',
                                ])
                            !!}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($company, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.company.show', $company),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($company, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.company.edit', $company),
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

                                @if(canDelete($company, $admin))
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
                        <td colspan="{{ $isRootAdmin ? '5' : '4' }}">No companies found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $companies->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
