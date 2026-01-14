@php
    $buttons = [];
    if (canCreate('skill', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Skill', 'href' => route('admin.portfolio.skill.create', $admin) ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => $pageTitle ?? 'Skills',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Skills' ],
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
                <th class="has-text-centered">featured</th>
                <th>category</th>
                <th>level (out of 10)</th>
                <th>years</th>
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
                <th class="has-text-centered">featured</th>
                <th>category</th>
                <th>level (out of 10)</th>
                <th>years</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($skills as $skill)

                <tr data-id="{{ $skill->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
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
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.portfolio.skill.destroy', [$admin, $skill->id]) !!}" method="POST">

                            @if(canRead($skill))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.skill.show', [$admin, $skill->id]),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($skill))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.skill.edit', [$admin, $skill->id]),
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

                            @if(canDelete($skill))
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
                    <td colspan="{{ isRootAdmin() ? '8' : '7' }}">There are no skills.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $skills->links('vendor.pagination.bulma') !!}

    </div>

@endsection
