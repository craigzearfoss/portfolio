@php
    $groups = $groups ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>name</th>
    <th>team</th>
    <th>owner</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($groups as $group)

        <tr data-id="{{ $group->id }}">
            <td>
                {!! $group->name !!}
            </td>
            <td>
                @include('admin.components.link', [
                    'name' => $group->team->name,
                    'href'  => route('admin.system.admin-team.show', [
                                           $group->team,
                                           'referer' => url()->current()
                                     ]),
                ])
            </td>
            <td>
                @include('admin.components.link', [
                    'name' => $group->owner->username,
                    'href'  => route('admin.system.admin.show', [
                                           $group->owner,
                                           'referer' => url()->current()
                                     ]),
                ])
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($group, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.system.admin-group.show', [
                                                   $group,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($group, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.system.admin-group.edit', [
                                                   $group,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($group, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.system.admin-group.destroy', $group) !!}"
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
