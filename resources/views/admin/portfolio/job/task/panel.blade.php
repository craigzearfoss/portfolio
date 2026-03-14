@php
    $coworkers = $coworkers ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Tasks

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Add a Task',
                'href'  => route('admin.portfolio.job-task.create', ['job_id' => $job->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add a task',
                'icon'  => 'fa-plus'
            ])

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.portfolio.job.task.table', [
        'tasks' => $tasks ?? []
    ])

</div>
