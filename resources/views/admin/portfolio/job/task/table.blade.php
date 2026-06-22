@php
    $tasks = $tasks ?? [];
@endphp
<table class="table admin-table task-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <tr>
        <th>summary</th>
        <th class="has-text-centered">public</th>
        <th class="has-text-centered">disabled</th>
        <th>actions</th>
    </tr>
    </thead>
    <tbody>

    @foreach ($tasks as $task)

        <tr data-id="{{ $task->id }}" {!! $task->is_disabled ? 'class="disabled-text"' : '' !!}>
            <td data-field="summary">
                {{ $task->summary ?? '' }}
            </td>
            <td data-field="is_public" class="has-text-centered">
                @include('admin.components.checkmark', [ 'checked' => $task->is_public ])
            </td>
            <td data-field="is_disabled" class="has-text-centered">
                @include('admin.components.checkmark', [ 'checked' => $task->is_disabled ])
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if (canRead($task, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.portfolio.job-task.show', [
                                                   $task,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if (canUpdate($task, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.portfolio.job-task.edit', [
                                                   $task,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if (canDelete($task, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.portfolio.job-task.destroy', $task) !!}"
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
