@extends('admin.layouts.default', [
    'title' => 'Educations',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Educations' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Education', 'href' => route('admin.portfolio.education.create') ],
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
                <th>academy</th>
                <th>year</th>
                <th>received</th>
                <th>expiration</th>
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
                <th>academy</th>
                <th>year</th>
                <th>received</th>
                <th>expiration</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($educations as $education)

                <tr data-id="{{ $education->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $education->owner['username'] ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $education->name }}
                    </td>
                    <td data-field="feature" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->feature ])
                    </td>
                    <td data-field="academy.name">
                        @if (!empty($education->academy))
                            @include('admin.components.link', [
                                'name'   => $education->academy['name'],
                                'href'   => route('admin.portfolio.academy.show', $education->academy),
                            ])
                        @endif
                    </td>
                    <td data-field="year">
                        {{ $education->year }}
                    </td>
                    <td data-field="received">
                        {{ shortDate($education->received) }}
                    </td>
                    <td data-field="expiration">
                        {{ shortDate($education->expiration) }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.education.destroy', $education->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.education.show', $education->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.education.edit', $education->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($education->link))
                                <a title="{{ !empty($education->link_name) ? $education->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $education->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '10' : '9' }}">There are no educations.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $educations->links('vendor.pagination.bulma') !!}

    </div>

@endsection
