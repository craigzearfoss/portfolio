@php
    use App\Models\Career\CoverLetter;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\CoverLetter';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Cover Letters';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                      'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',   'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications', 'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Cover Letters' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(CoverLetter::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Cover Letter',
                                                                  'href' => route('admin.career.cover-letter.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-cover-letter', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.cover-letter.export', request()->except([ 'page' ])),
                'filename' => 'cover_letters_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($coverLetters->total()) }} {{ ($coverLetters->total() === 1) ? 'cover letter' : 'cover letters' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $coverLetters->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <p class="admin-table-caption"></p>

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
                                'name'  => 'company',
                                'sort'  => 'company_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'role',
                                'sort'  => 'application_role|asc',
                            ])
                        </th>
                        <th style="white-space: nowrap;">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'apply date',
                                'sort'  => 'application_apply_date|desc',
                            ])
                        </th>
                        <th class="has-text-centered">active</th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($coverLetters as $coverLetter)

                    <tr data-id="{{ $coverLetter->id }}">
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $coverLetter->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name' => $coverLetter->owner->username,
                                    'href' => route('admin.system.admin.show', $coverLetter->owner)
                                ])
                            </td>
                        @endif
                        <td data-field="company.name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => $coverLetter->application->company->name,
                                'href' => route('admin.career.company.show', $coverLetter->application->company)
                            ])
                        </td>
                        <td data-field="role" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name' => $coverLetter->application->role,
                                'href' => route('admin.career.application.show', $coverLetter->application)
                            ])
                        </td>
                        <td data-field="post_date" style="white-space: nowrap;">
                            {{ shortDate($coverLetter->application['apply_date'] ?? null) }}
                        </td>
                        <td data-field="application.active" data-field="" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $coverLetter->application->active ?? 0 ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $coverLetter->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($coverLetter, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.cover-letter.show', ownerParams($coverLetter, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($coverLetter, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.cover-letter.edit',
                                                          ownerParams($coverLetter, request()->input('owner_id'), $admin)
                                                   ),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($coverLetter->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($coverLetter->link_name) ? $coverLetter->link_name : 'link',
                                        'href'   => $coverLetter->link,
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

                                @if (canDelete($coverLetter, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.cover-letter.destroy', $coverLetter) !!}" method="POST">
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
                        <td colspan="{{ $isRootAdmin ? '8' : '6' }}">No cover letters found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $coverLetters->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
