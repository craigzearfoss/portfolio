@php
    $coworkers = $coworkers ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h2 class="subtitle">

        Tasks

        @if(!empty($job))

            @include('admin.components.link', [
                'name'  => 'Add a Task',
                'href'  => route('admin.portfolio.job-task.create', ['job_id' => $job->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add a task',
                'icon'  => 'fa-plus'
            ])

        @endif

    </h2>

    @include('admin.portfolio.job.task.table', [
        'tasks' => $tasks ?? []
    ])

</div>
