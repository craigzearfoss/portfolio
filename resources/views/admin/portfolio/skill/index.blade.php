@extends('admin.layouts.default', [
    'title' => 'Skills',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Skills' ],
    ],
    'buttons' => [
        canCreate('skill')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Skill', 'href' => route('admin.portfolio.skill.create') ]]
            : [],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                        {{ $skill->name . (!empty($skill->version) ? ' ' . $skill->version : '') }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $skill->featured ])
                    </td>
                    <td data-field="dictionary_category_id">
                        <?php /* @TODO: fix this
                        @if(!empty($skill->category->name))
                            {{ $skill->category->name ?? '' }}
                        @endif
                        */ ?>
                    </td>
                    <td data-field="level" style="white-space: nowrap;">
                        @include('admin.components.star-ratings', [
                            'rating' => $skill->level ?? 1,
                            'label'  => '(' . ($skill->level ?? 1) . ')'
                        ])
                    </td>
                    <td data-field="years" class="has-text-centered">
                        {{ $skill->years }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $skill->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $skill->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.skill.destroy', $skill->id) }}" method="POST">

                            @if(canRead($skill))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.skill.show', $skill->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($skill))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.skill.edit', $skill->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($skill->link))
                                <a title="{{ !empty($skill->link_name) ? $skill->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $skill->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($skill))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
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
