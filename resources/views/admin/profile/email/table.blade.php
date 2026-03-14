@php
    $emails = $emails ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>email</th>
    <th>label</th>
    <th>description</th>
    <th>active</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($emails as $email)

        <tr>
            <td>
                {!! $email->email !!}
            </td>
            <td>
                {!! $email->label !!}
            </td>
            <td>
                {!! $email->description !!}
            </td>
            <td>
                @include('admin.components.checkmark', [ 'checked' => !$email->is_disabled ])
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($email, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.system.admin-email.show', [
                                                   $email,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($email, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.system.admin-email.edit', [
                                                   $email,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($email, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.system.admin-email.destroy', $email) !!}"
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
