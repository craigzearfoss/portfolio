@php
    use App\Models\Portfolio\Education;
    use Illuminate\Support\Carbon;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Portfolio\Education';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Education';
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
    $breadcrumbs[] = [ 'name' => 'Education' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Education::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Education', 'href' => route('admin.portfolio.education.create', $owner ?? $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.portfolio-education', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 80em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.education.export', request()->except([ 'page' ])),
                'filename' => 'educations_' . date("Y-m-d-His") . '.xlsx',
            ])

            @if($pagination_top)
                {!! $educations->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption">* An asterisk indicates a featured education.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th class="has-text-centered">degree</th>
                        <th>major</th>
                        <th>minor</th>
                        <th>school</th>
                        <th class="has-text-centered">enrolled</th>
                        <th class="has-text-centered">graduated</th>
                        <th class="has-text-centered">currently<br>enrolled</th>
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
                        <th class="has-text-centered">degree</th>
                        <th>major</th>
                        <th>minor</th>
                        <th>school</th>
                        <th class="has-text-centered">enrolled</th>
                        <th class="has-text-centered">graduated</th>
                        <th class="has-text-centered">currently<br>enrolled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($educations as $education)

                    <tr data-id="{{ $education->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $education->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="degreeType.name">
                            {!! $education->degreeType->name ?? '' !!}
                        </td>
                        <td data-field="major" style="white-space: nowrap;">
                            {!! $education->major !!}{!! !empty($education->featured) ? '<span class="featured-splat">*</span>' : '' !!}
                        </td>
                        <td data-field="minor">
                            {!! $education->minor !!}
                        </td>
                        <td data-field="school.name">
                            {!! $education->school->name ?? '' !!}
                        </td>
                        <td data-field="enrollment_date" class="has-text-centered">
                            {{ !empty($education->enrollment_date) ? Carbon::parse($education->enrollment_date)->format("M y") : '' }}
                        </td>
                        <td data-field="graduation_date" class="has-text-centered">
                            {{ !empty($education->graduation_date) ? Carbon::parse($education->graduation_date)->format("M y") : '' }}
                        </td>
                        <td data-field="currently_enrolled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $education->currently_enrolled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($education, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.education.show', $education),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($education, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.education.edit', $education),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($education->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($education->link_name) ? $education->link_name : 'link',
                                        'href'   => $education->link,
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

                                @if(canDelete($education, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.education.destroy', $education) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '9' : '8' }}">No education found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $educations->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
