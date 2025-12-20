@php
    $buttons = [];
    if (canCreate('reference', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Reference', 'href' => route('admin.career.reference.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'References',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'References' ]
    ],
    'buttons'       => $buttons,
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
                <th>relation</th>
                <th>phone</th>
                <th>email</th>
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
                <th>relation</th>
                <th>phone</th>
                <th>email</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($references as $reference)

                <tr data-id="{{ $reference->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $reference->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name" style="white-space: nowrap;">
                        {{ $reference->name }}
                    </td>
                    <td data-field="relation">
                        {{ $reference->relation ?? '' }}
                    </td>
                    <td data-field="name" style="white-space: nowrap;">
                        {{ $reference->phone }}
                    </td>
                    <td data-field="name" style="white-space: nowrap;">
                        {{ $reference->email }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reference->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $reference->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.reference.destroy', $reference->id) }}" method="POST">

                            @if(canRead($reference))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.reference.show', $reference->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($reference))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.reference.edit', $reference->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                        @if (!empty($reference->link))
                                <a title="{{ !empty($reference->link_name) ? $reference->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $reference->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($reference))
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
                    <td colspan="{{ isRootAdmin() ? '8' : '7' }}">There are no references.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $references->links('vendor.pagination.bulma') !!}

    </div>

@endsection
