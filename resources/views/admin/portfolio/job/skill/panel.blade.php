@php
    $skils = $skills ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="floating-div-container">
    <div class="show-container card floating-div">

        <h2 class="subtitle">

            Skills

            @if(!empty($job))

                @include('admin.components.link', [
                    'name'  => 'Add a Skill',
                    'href'  => route('admin.portfolio.job-skill.create', ['job_id' => $job->id]),
                    'class' => 'button is-primary is-small px-1 py-0',
                    'title' => 'add a skill',
                    'icon'  => 'fa-plus'
                ])

            @endif

        </h2>

        @include('admin.portfolio.job.skill.table', [
            'skills' => $skills ?? []
        ])

    </div>
</div>
