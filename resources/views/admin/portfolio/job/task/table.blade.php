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
