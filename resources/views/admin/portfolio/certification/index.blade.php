@extends('admin.layouts.default', [
    'title' => 'Certifications',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Certification', 'href' => route('admin.portfolio.certification.create') ],
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

            @forelse ($certifications as $certification)

                <tr data-id="{{ $certification->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $certification->owner['username'] ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $certification->name }}
                    </td>
                    <td data-field="feature" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certification->feature ])
                    </td>
                    <td data-field="academy.name">
                        @if (!empty($certification->academy))
                            @include('admin.components.link', [
                                'name'   => $certification->academy['name'],
                                'href'   => route('admin.portfolio.academy.show', $certification->academy),
                            ])
                        @endif
                    </td>
                    <td data-field="year">
                        {{ $certification->year }}
                    </td>
                    <td data-field="received">
                        {{ shortDate($certification->received) }}
                    </td>
                    <td data-field="expiration">
                        {{ shortDate($certification->expiration) }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certification->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certification->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.certification.destroy', $certification->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.certification.show', $certification->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.certification.edit', $certification->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($certification->link))
                                <a title="{{ !empty($certification->link_name) ? $certification->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $certification->link }}"
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
                    <td colspan="{{ isRootAdmin() ? '10' : '9' }}">There are no certifications.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $certifications->links('vendor.pagination.bulma') !!}

    </div>

@endsection
