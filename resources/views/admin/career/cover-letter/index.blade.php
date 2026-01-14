@php
    $buttons = [];
    if (canCreate('cover-letter', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Cover Letter', 'href' => route('admin.career.cover-letter.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Cover Letters',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters' ]
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
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
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
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
            */ ?>
            <tbody>

            @forelse ($coverLetters as $coverLetter)

                <tr data-id="{{ $coverLetter->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
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
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.career.cover-letter.destroy', $coverLetter->id) !!}" method="POST">

                            @if(canRead($coverLetter))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.cover-letter.show', $coverLetter->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($coverLetter))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.career.cover-letter.edit', $coverLetter->id),
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

                            @if(canDelete($coverLetter))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There are no cover letters.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $coverLetters->links('vendor.pagination.bulma') !!}

    </div>

@endsection
