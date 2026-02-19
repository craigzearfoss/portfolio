@php
    $contacts = $contacts ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>name</th>
    <th>active</th>
    <th>phone</th>
    <th>email</th>
    <th>actions</th>
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
                           href="{{ route('admin.career.contact.show', $contact) }}">
                        <i class="fa-solid fa-list"></i>
                    </a>

                    @csrf
                    @method('DELETE')
                    <button title="remove" type="submit" class="button is-small px-1 py-0">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
