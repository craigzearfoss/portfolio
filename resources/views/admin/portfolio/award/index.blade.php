@extends('admin.layouts.default', [
    'title' => 'Award',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Award' ],
    ],
    'buttons' => [
        canCreate('award')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Award', 'href' => route('admin.portfolio.award.create') ]]
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
                <th>year</th>
                <th>organization</th>
                <th class="has-text-centered">featured</th>
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
                <th>year</th>
                <th>organization</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($awards as $award)

                <tr data-id="{{ $award->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $award->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $award->name }}
                    </td>
                    <td data-field="year">
                        {{ $award->year }}
                    </td>
                    <td data-field="organization">
                        {{ $award->organization }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $award->featured ])
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $award->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $award->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.award.destroy', $award->id) }}" method="POST">

                            @if(canRead($award))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.award.show', $award->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($award))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.award.edit', $award->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($award->link))
                                <a title="{{ !empty($award->link_name) ? $award->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $award->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($award))
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
                    <td colspan="{{ isRootAdmin() ? '8' : '7' }}">There are no awards.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $awards->links('vendor.pagination.bulma') !!}

    </div>

@endsection
