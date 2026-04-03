@php
    $contacts = $contacts ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>name</th>
    <th>phone</th>
    <th>email</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($contacts as $contact)

        <tr>
            <td>
                {!! $contact->name !!}
            </td>
            <td>
                {{ $contact->phone }}
            </td>
            <td>
                {{ $contact->email }}
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($contact, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.career.contact.show', [
                                                   $contact,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($contact, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.career.contact.edit', [
                                                   $contact,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($contact, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.career.contact.destroy', $contact) !!}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            @include('admin.components.button-icon', [
                                'title' => 'delete',
                                'class' => 'delete-btn',
                                'icon'  => 'fa-trash'
                            ])
                        </form>
                    @endif

                </div>

            </td>
        </tr>

    @endforeach

    </tbody>
</table>
