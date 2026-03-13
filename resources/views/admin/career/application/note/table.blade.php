@php
    $notes = $notes ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>subject</th>
    <th>body</th>
    <th>time</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($notes as $note)

        <tr>
            <td>
                {!! $note->subject !!}
            </td>
            <td>
                {!! $note->body !!}
            </td>
            <td>
                {{ longDateTime($note->created_at) }}
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($note, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.career.note.show', [
                                                   $note,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($note, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.career.note.edit', [
                                                   $note,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($note, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.career.note.destroy', $note) !!}"
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
