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
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>location</th>
                <th>phone</th>
                <th>email</th>
                <th class="text-center">public</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>location</th>
                <th>phone</th>
                <th>email</th>
                <th class="text-center">public</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($companies as $company)

                <tr>
                    <td>
                        {{ $company->name }}
                    </td>
                    <td>
                        @if ($company->city)
                            {{ $company->city }}@if ($company->state)
                                , {{ $company->state }}
                            @endif
                        @else
                            {{ $company->state }}
                        @endif
                    </td>
                    <td>
                        {{ $company->phone }}
                    </td>
                    <td>
                        {{ $company->email }}
                    </td>
                    <td class="text-center">
                        @include('admin.components.checkmark', [ 'checked' => $company->public ])
                    </td>
                    <td class="text-center">
                        @include('admin.components.checkmark', [ 'checked' => $company->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.company.destroy', $company->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.company.show', $company->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.company.edit', $company->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($company->website))
                                <a title="website" class="button is-small px-1 py-0" href="{{ $company->website }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- website--}}
                                </a>
                            @else
                                <a title="website" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- website--}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7">There are no companies.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $companies->links('vendor.pagination.bulma') !!}

    </div>

@endsection
