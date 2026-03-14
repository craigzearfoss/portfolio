@php
    $coworkers = $coworkers ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Events

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Add a Coworker',
                'href'  => route('admin.portfolio.job-coworker.create', ['job_id' => $job->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add a coworker',
                'icon'  => 'fa-plus'
            ])

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.portfolio.job.coworker.table', [
        'coworkers' => $coworkers ?? []
    ])

</div>
