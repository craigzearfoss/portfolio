@php
    $buttons = [];
    if (canCreate('skill', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Skill', 'href' => route('admin.portfolio.skill.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Skills',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Skills' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        @if($pagination_top)
            {!! $skills->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                <th>name</th>
                <th class="has-text-centered">featured</th>
                <th>category</th>
                <th>level (out of 10)</th>
                <th>years</th>
                <th class="has-text-centered">public</th>
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
                    <th>name</th>
                    <th class="has-text-centered">featured</th>
                    <th>category</th>
                    <th>level (out of 10)</th>
                    <th>years</th>
                    <th class="has-text-centered">public</th>
                    <th class="has-text-centered">disabled</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($skills as $skill)

                <tr data-id="{{ $skill->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $skill->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name" style="white-space: nowrap;">
                        {!! $skill->name . (!empty($skill->version) ? ' ' . $skill->version : '') ?? '' !!}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $skill->featured ])
                    </td>
                    <td data-field="dictionary_category_id">
                        <?php /* @TODO: fix this
                        @if(!empty($skill->category->name))
                            {!! $skill->category->name !!}
                        @endif
                        */ ?>
                    </td>
                    <td data-field="level" style="white-space: nowrap;">
                        @include('admin.components.star-ratings', [
                            'rating' => $skill->level,
                            'label'  => "({$skill->level})"
                        ])
                    </td>
                    <td data-field="years" class="has-text-centered">
                        {!! $skill->years !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $skill->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $skill->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($skill, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.skill.show', $skill),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($skill, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.skill.edit', $skill),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($skill->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($skill->link_name) ? $skill->link_name : 'link',
                                    'href'   => $skill->link,
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

                            @if(canDelete($skill, $admin))
                                <form class="delete-resource" action="{!! route('admin.portfolio.skill.destroy', $skill) !!}" method="POST">
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
                    <td colspan="{{ $admin->root ? '9' : '8' }}">There are no skills.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $skills->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
