@extends('admin.layouts.default', [
    'title'         => 'Certificates',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certificates' ],
    ],
    'buttons'       => [
        canCreate('certificate')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Certificate', 'href' => route('admin.portfolio.certificate.create') ]]
            : [],
    ],
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
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

            @forelse ($certificates as $certificate)

                <tr data-id="{{ $certificate->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $certificate->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $certificate->name }}
                    </td>
                    <td data-field="feature" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certificate->feature ])
                    </td>
                    <td data-field="academy.name">
                        @if (!empty($certificate->academy))
                            @include('admin.components.link', [
                                'name'   => $certificate->academy['name'],
                                'href'   => route('admin.portfolio.academy.show', $certificate->academy),
                            ])
                        @endif
                    </td>
                    <td data-field="year">
                        {{ $certificate->year }}
                    </td>
                    <td data-field="received">
                        {{ shortDate($certificate->received) }}
                    </td>
                    <td data-field="expiration">
                        {{ shortDate($certificate->expiration) }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certificate->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $certificate->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.certificate.destroy', $certificate->id) }}" method="POST">

                            @if(canRead($certificate))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.certificate.show', $certificate->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($certificate))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.certificate.edit', $certificate->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($certificate->link))
                                <a title="{{ !empty($certificate->link_name) ? $certificate->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $certificate->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($certificate))
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
                    <td colspan="{{ isRootAdmin() ? '10' : '9' }}">There are no certificates.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $certificates->links('vendor.pagination.bulma') !!}

    </div>

@endsection
