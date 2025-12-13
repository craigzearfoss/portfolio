@extends('admin.layouts.default', [
    'title' => 'Contacts',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Contacts' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Contact', 'href' => route('admin.career.contact.create') ],
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
                <th>company</th>
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
                <th>company</th>
                <th>phone</th>
                <th>email</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($contacts as $contact)

                <tr data-id="{{ $contact->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $contact->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="name" style="white-space: nowrap;">
                        {{ $contact->name }}
                    </td>
                    <td data-field="contact.company.names" style="white-space: nowrap;">
                        {{ implode(', ', $contact->companies->pluck('name')->toArray()) }}
                    </td>
                    <td data-field="phone" style="white-space: nowrap;">
                        {{ $contact->phone }}
                    </td>
                    <td data-field="email" style="white-space: nowrap;">
                        {{ $contact->email }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $contact->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $contact->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.contact.destroy', $contact->id) }}" method="POST">

                            @if(canRead($contact))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.contact.show', $contact->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($contact))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.contact.edit', $contact->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($contact->link))
                                <a title="{{ !empty($contact->link_name) ? $contact->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $contact->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($contact))
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
                    <td colspan="{{ isRootAdmin() ? '8' : '7' }}">There are no contacts.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $contacts->links('vendor.pagination.bulma') !!}

    </div>

@endsection
