@php
    $applications = $applications ?? [];
@endphp
<p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the application is disabled.</p>

<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <tr>
        <th>role</th>
        <th>active</th>
        <th>posted</th>
        <th>applied</th>
        <th>closed</th>
        <th>actions</th>
    </tr>
    </thead>
    <tbody>

    @foreach ($applications as $application)

        <tr data-id="{{ $application->id }}" {!! $application->is_disabled ? 'class="disabled-text"' : '' !!}>
            <td style="white-space: nowrap;">
                {!! htmlspecialchars($application->role) !!}
            </td>
            <td>
                @include('admin.components.checkmark', [ 'checked' => $application->active ])
            </td>
            <td style="white-space: nowrap;">
                {{ !empty($application->post_date) ? date('M j, Y', strtotime($application->post_date)) : '' }}
            </td>
            <td style="white-space: nowrap;">
                {{ !empty($application->apply_date) ? date('M j, Y', strtotime($application->apply_date)) : '' }}
            </td>
            <td style="white-space: nowrap;">
                {{ !empty($application->close_date) ? date('M j, Y', strtotime($application->close_date)) : '' }}
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if (canRead($application, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.career.application.show', [
                                                   $application,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if (canUpdate($application, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.career.application.edit', [
                                                   $application,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    <?php /*
                    @if (canDelete($application, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.career.application.destroy', $application) !!}"
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
                    */ ?>

                </div>

            </td>
        </tr>

    @endforeach

    </tbody>
</table>
