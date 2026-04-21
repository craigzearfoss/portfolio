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
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(CoverLetter::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Cover Letter', 'href' => route('admin.career.cover-letter.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-cover-letter', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container')

            @if($pagination_top)
                {!! $coverLetters->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>company</th>
                        <th>role</th>
                        <th style="white-space: nowrap;">apply date</th>
                        <th class="has-text-centered">active</th>
                        <th class="has-text-centered">disabled</th>
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
                        <th>company</th>
                        <th>role</th>
                        <th style="white-space: nowrap;">apply date</th>
                        <th class="has-text-centered">active</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($coverLetters as $coverLetter)

                    <tr data-id="{{ $coverLetter->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $coverLetter->owner->username }}
                            </td>
                        @endif
                        <td data-field="company.name" style="white-space: nowrap;">
                            {!! $coverLetter->application->company->name ?? '' !!}
                        </td>
                        <td data-field="role" style="white-space: nowrap;">
                            {!! $coverLetter->application->role ?? '' !!}
                        </td>
                        <td data-field="post_date" style="white-space: nowrap;">
                            {{ shortDate($coverLetter->application['apply_date'] ?? null) }}
                        </td>
                        <td data-field="application.active" data-field="" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $coverLetter->application->active ?? 0 ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $coverLetter->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($coverLetter, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.cover-letter.show', $coverLetter),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($coverLetter, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.cover-letter.edit', $coverLetter),
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

                                @if(canDelete($coverLetter, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.career.cover-letter.destroy', $coverLetter) !!}"
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
                        <td colspan="{{ $isRootAdmin ? '7' : '6' }}">No cover letters found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $coverLetters->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
