@php
$notes = $notes ?? [];
@endphp
<table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
    <thead>
    <th>name</th>
    <th>active</th>
    <th>phone</th>
    <th>email</th>
    <th>Actions</th>
    </thead>
    <tbody>

    @foreach($contacts as $contact)

        <tr>
            <td>
                @include('admin.components.link', [
                    'name' => $contact->name,
                    'href' => route('admin.career.contact.show', $contact)
                ])
            </td>
            <td data-field="featured" class="has-text-centered">
                @include('admin.components.checkmark', [ 'checked' => $contact->pivot->active ])
            </td>
            <td>
                {{ $contact->phone ?? '' }}
            </td>
            <td>
                {{ $contact->email ?? '' }}
            </td>
            <td class="is-1" style="white-space: nowrap;">
                <form action="{{ route('admin.career.company.contact.detach', [
                        $contact->pivot->company_id,
                        $contact->pivot->contact_id
                    ]) }}"
                      method="POST"
                >

                    <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.company.contact.add', [$contact->pivot->company_id]) }}">
                        <i class="fa-solid fa-list"></i>{{-- show --}}
                    </a>

                    @csrf
                    @method('DELETE')
                    <button title="delete" type="submit" class="button is-small px-1 py-0">
                        <i class="fa-solid fa-trash"></i>{{-- delete --}}
                    </button>
                </form>
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
