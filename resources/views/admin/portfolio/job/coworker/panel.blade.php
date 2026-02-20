@php
    $coworkers = $coworkers ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="floating-div-container">
    <div class="show-container card floating-div">

        <h2 class="subtitle">

            Coworkers

            @if(!empty($job))

                @include('admin.components.link', [
                    'name'  => 'Add a Coworker',
                    'href'  => route('admin.portfolio.job-coworker.create', ['job_id' => $job->id]),
                    'class' => 'button is-primary is-small px-1 py-0',
                    'title' => 'add a coworker',
                    'icon'  => 'fa-plus'
                ])

            @endif

        </h2>

        @include('admin.portfolio.job.coworker.table', [
            'coworkers' => $coworkers ?? []
        ])

    </div>
</div>
