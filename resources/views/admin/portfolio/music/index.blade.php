@php
    $buttons = [];
    if (canCreate('music', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Music', 'href' => route('admin.portfolio.music.create', $admin) ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => $pageTitle ?? 'Music',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Music' ],
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
                <th>name</th>
                <th>artist</th>
                <th class="has-text-centered">featured</th>
                <th>year</th>
                <th>label</th>
                <th>cat#</th>
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
                <th>name</th>
                <th>artist</th>
                <th class="has-text-centered">featured</th>
                <th>year</th>
                <th>label</th>
                <th>cat#</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($musics as $music)

                <tr data-id="{{ $music->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $music->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {!! $music->name !!}
                    </td>
                    <td data-field="artist">
                        {!! $music->artist !!}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $music->featured ])
                    </td>
                    <td data-field="year">
                        {!! $music->year !!}
                    </td>
                    <td data-field="label">
                        {!! $music->label !!}
                    </td>
                    <td data-field="catalog_number">
                        {!! $music->catalog_number !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $music->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $music->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.portfolio.music.destroy', [$admin, $music->id]) !!}" method="POST">

                            @if(canRead($music))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.music.show', [$admin, $music->id]),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($music))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.music.edit', [$admin, $music->id]),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($music->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($music->link_name) ? $music->link_name : 'link',
                                    'href'   => $music->link,
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

                            @if(canDelete($music))
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
                    <td colspan="{{ isRootAdmin() ? '10' : '9' }}">There is no music.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $musics->links('vendor.pagination.bulma') !!}

    </div>

@endsection
