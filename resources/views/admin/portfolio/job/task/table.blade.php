@php
    $tasks = $tasks ?? [];
@endphp
<table class="table admin-table task-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>summary</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($tasks as $task)

        <tr>
            <td data-field="summary">
                {{ $task->summary ?? '' }}
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($task, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.portfolio.job-task.show', [
                                                   $task,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($task, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.portfolio.job-task.edit', [
                                                   $task,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($task, $admin))
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




            <td class="is-1" style="white-space: nowrap;">

                <a title="show" class="button is-small px-1 py-0"
                       href="{{ route('admin.portfolio.job-task.show', $task) }}">
                    <i class="fa-solid fa-list"></i>
                </a>

                <a title="edit" class="button is-small px-1 py-0"
                   href="{{ route('admin.portfolio.job-task.edit', $task) }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>

                <button title="remove" type="submit" class="button is-small px-1 py-0">
                    <i class="fa-solid fa-trash"></i>
                </button>

            </td>
        </tr>

    @endforeach

    </tbody>
</table>
