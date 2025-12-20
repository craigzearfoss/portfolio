@extends('admin.layouts.default', [
    'title'         => 'Companies',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Companies' ]
    ],
    'buttons'       => [
        canCreate('company')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Company', 'href' => route('admin.career.company.create') ]]
            : [],
    ],
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
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
                <th>industry</th>
                <th>location</th>
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
                <th>industry</th>
                <th>location</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($companies as $company)

                <tr data-id="{{ $company->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $company->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $company->name }}
                    </td>
                        <td data-field="industry.name">
                            {{ $company->industry['name'] ?? '' }}
                        </td>
                    <td data-field="location" style="white-space: nowrap;">
                        {!!
                            formatLocation([
                                'city'    => $company->city ?? null,
                                'state'   => $company->state['code'] ?? null,
                            ])
                        !!}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.company.destroy', $company->id) }}" method="POST">

                            @if(canRead($company))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.company.show', $company->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($company))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.company.edit', $company->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($company->link))
                                <a title="{{ !empty($company->link_name) ? $company->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $company->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($company))
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
                    <td colspan="{{ isRootAdmin() ? '5' : '4' }}">There are no companies.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $companies->links('vendor.pagination.bulma') !!}

    </div>

@endsection
