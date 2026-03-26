@php
    $communications = $communications ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>type</th>
    <th>subject</th>
    <th>to</th>
    <th>from</th>
    <th class="has-text-centered">date</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($communications as $communication)

        <tr>
            <td>
                {!! $communication->communicationType->name ?? '' !!}
            </td>
            <td>
                {!! $communication->subject !!}
            </td>
            <td>
                {!! $communication->to !!}
            </td>
            <td>
                {!! $communication->from !!}
            </td>
            <td class="has-text-centered">
                <span style="white-space: nowrap">
                    {{ shortDateTime($communication->date . ' ' . $communication->time) }}
                </span>
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($communication, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.career.communication.show', [
                                                   $communication,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($communication, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.career.communication.edit', [
                                                   $communication,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($communication, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.career.communication.destroy', $communication) !!}"
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
