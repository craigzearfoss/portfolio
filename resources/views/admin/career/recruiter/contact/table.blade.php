@php
    $contacts = $contacts ?? [];
@endphp
<p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the contact is disabled.</p>

<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <tr>
        <th>name</th>
        <th>phone</th>
        <th>email</th>
        <th>actions</th>
    </tr>
    </thead>
    <tbody>

    @foreach ($contacts as $contact)

        <tr data-id="{{ $contact->id }}" {!! $contact->is_disabled ? 'class="disabled-text"' : '' !!}>
            <td>
                {!! htmlspecialchars($contact->name) !!}
            </td>
            <td>
                {!! htmlspecialchars($contact->phone) !!}
            </td>
            <td>
                {!! htmlspecialchars($contact->email) !!}
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if (canRead($contact, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.career.contact.show', [
                                                   $contact,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if (canUpdate($contact, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.career.contact.edit', [
                                                   $contact,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if (canDelete($contact, $admin))
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
