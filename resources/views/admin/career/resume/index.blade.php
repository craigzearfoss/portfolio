@php
    use App\Models\Career\Resume;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Resume';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ??  'Resumes' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',               'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',             'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,      'href' => route('admin.career.application.index') ],
            [ 'name' => $application['name'], 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Resumes' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Resumes' ]
        ];
    }

    // set navigation buttons
    $navButtons = [];
    $navButtons[] = view('admin.components.nav-button', [ 'name'  => 'Preview Current Resume',
                                                          'href'  => route('admin.career.resume.preview', $owner),
                                                          'class' => 'button is-small is-dark my-0 nav-button',
                                                          'icon'  => 'fa-eye',
                                                        ])->render();
    if (canCreate(Resume::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Resume', 'href' => route('admin.career.resume.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-resume', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $resumes->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        <th class="has-text-centered">date</th>
                        <th class="has-text-centered">primary</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered" style="display: none;">disabled</th>
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
                        <th class="has-text-centered">date</th>
                        <th class="has-text-centered">primary</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered" style="display: none;">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($resumes as $resume)

                    <tr data-id="{{ $resume->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $resume->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $resume->name !!}
                        </td>
                        <td data-field="resume_date" class="has-text-centered" style="white-space: nowrap;">
                            {{ shortDate($resume->resume_date) }}
                        </td>
                        <td data-field="primary" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resume->primary ])
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $resume->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $resume->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($resume, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.resume.show', $resume),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($resume, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.resume.edit', $resume),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($resume->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($resume->link_name) ? $resume->link_name : 'link',
                                        'href'   => $resume->link,
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

                                @if(canDelete($resume, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.career.resume.destroy', $resume) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '7' : '6' }}">No resumes found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $resumes->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
