@php
    $phones = $phones ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>phone</th>
    <th>label</th>
    <th>description</th>
    <th>active</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($phones as $phone)

        <tr>
            <td>
                {!! $phone->phone !!}
            </td>
            <td>
                {!! $phone->label !!}
            </td>
            <td>
                {!! $phone->description !!}
            </td>
            <td>
                @include('admin.components.checkmark', [ 'checked' => !$phone->is_disabled ])
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($phone, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.system.admin-phone.show', [
                                                   $phone,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($phone, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.system.admin-phone.edit', [
                                                   $phone,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($phone, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.system.admin-phone.destroy', $phone) !!}"
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
