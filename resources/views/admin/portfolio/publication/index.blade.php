@php
    $buttons = [];
    if (canCreate('publication', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Publication', 'href' => route('admin.portfolio.publication.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Publications',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Publications' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>title</th>
                <th class="has-text-centered">featured</th>
                <th>publication<br>name</th>
                <th>publisher</th>
                <th class="has-text-centered">year</th>
                <th class="has-text-centered">public</th>
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
                <th>title</th>
                <th class="has-text-centered">featured</th>
                <th>publication<br>name</th>
                <th>publisher</th>
                <th class="has-text-centered">year</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($publications as $publication)

                <tr data-id="{{ $publication->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $publication->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="title">
                        {{ htmlspecialchars($publication->title ?? '') }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $publication->featured ])
                    </td>
                    <td data-field="publication_name">
                        {{ htmlspecialchars($publication->publication ?? '') }}
                    </td>
                    <td data-field="publisher">
                        {{ htmlspecialchars($publication->publisher ?? '') }}
                    </td>
                    <td data-field="year">
                        {{ $publication->year }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $publication->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $publication->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{{ route('admin.portfolio.publication.destroy', $publication->id) }}" method="POST">

                            @if(canRead($publication))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.publication.show', $publication->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($publication))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.publication.edit', $publication->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($publication->link))
                                @include('admin.components.link-icon', [
                                    'title'  => htmlspecialchars((!empty($publication->link_name) ? $publication->link_name : 'link') ?? ''),
                                    'href'   => $publication->link,
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

                            @if(canDelete($publication))
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
                    <td colspan="{{ isRootAdmin() ? '9' : '8' }}">There are no publications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $publications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
