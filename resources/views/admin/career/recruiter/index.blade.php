@extends('admin.layouts.default', [
    'title' => 'Recruiters',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Recruiters' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recruiter', 'url' => route('admin.career.recruiter.create') ],
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
                <th>name</th>
                <th>location</th>
                <th>phone</th>
                <th>email</th>
                <th class="has-text-centered">local</th>
                <th class="has-text-centered">regional</th>
                <th class="has-text-centered">national</th>
                <th class="has-text-centered">international</th>
                <th class="has-text-centered">disabled</th>
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
                <th class="has-text-centered">local</th>
                <th class="has-text-centered">regional</th>
                <th class="has-text-centered">national</th>
                <th class="has-text-centered">international</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recruiters as $recruiter)

                <tr data-id="{{ $recruiter->id }}">
                    @if(isRootAdmin())
                        <td data-field="admin.username">
                            @if(!empty($recruiter->admin))
                                @include('admin.components.link', [
                                    'name' => $recruiter->admin['username'],
                                    'url'  => route('admin.admin.show', $recruiter->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $recruiter->name }}
                    </td>
                    <td data-field="location">
                        {!!
                            formatLocation([
                                'city'    => $recruiter->city ?? null,
                                'state'   => $recruiter->state['code'] ?? null,
                            ])
                        !!}
                    </td>
                    <td data-field="phone">
                        {{ $recruiter->phone }}
                    </td>
                    <td data-field="email">
                        {{ $recruiter->email }}
                    </td>
                    <td data-field="local" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->local ])
                    </td>
                    <td data-field="regional" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->regional ])
                    </td>
                    <td data-field="national" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->national ])
                    </td>
                    <td data-field="international" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->international ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recruiter->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.recruiter.destroy', $recruiter->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.recruiter.show', $recruiter->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.recruiter.edit', $recruiter->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($recruiter->link))
                                <a title="{{ !empty($recruiter->link_name) ? $recruiter->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $recruiter->link }}"
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
                    <td colspan="10">There are no recruiters.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recruiters->links('vendor.pagination.bulma') !!}

    </div>

@endsection
