@php
    use App\Enums\PermissionEntityTypes;

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
    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'cover-letter', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Cover Letter', 'href' => route('admin.career.cover-letter.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(isRootAdmin())
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.career.cover-letter.index') ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $coverLetters->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if($admin->root)
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

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->root))
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
                        @if($admin->root)
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
                        <td data-field="disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $coverLetter->disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $coverLetter, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.cover-letter.show', $coverLetter),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $coverLetter, $admin))
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

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $coverLetter, $admin))
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
                        <td colspan="{{ $admin->root ? '7' : '6' }}">There are no cover letters.</td>
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
