@extends('admin.layouts.default', [
    'title' => 'Companies',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Companies' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Company', 'url' => route('admin.career.company.create') ],
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
                    <th>admin</th>
                @endif
                <th>name</th>
                <th>location</th>
                <th>phone</th>
                <th>email</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>admin</th>
                @endif
                <th>name</th>
                <th>location</th>
                <th>phone</th>
                <th>email</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($companies as $company)

                <tr data-id="{{ $company->id }}">
                    @if(isRootAdmin())
                        <td>
                            {{ $application->admin['username'] ?? '' }}
                        </td>
                    @endif
                    <td>
                        {{ $company->name }}
                    </td>
                    <td>
                        {!!
                            formatLocation([
                                'city'    => $company->city ?? null,
                                'state'   => $company->state['code'] ?? null,
                            ])
                        !!}
                    </td>
                    <td>
                        {{ $company->phone }}
                    </td>
                    <td>
                        {{ $company->email }}
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.company.destroy', $company->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.company.show', $company->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.company.edit', $company->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($company->link))
                                <a title="{{ !empty($company->link_name) ? $company->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $company->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- Delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no companies.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $companies->links('vendor.pagination.bulma') !!}

    </div>

@endsection
