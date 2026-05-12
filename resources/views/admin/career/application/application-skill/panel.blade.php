@php
    $application       = $application ?? null;
    $applicationSkills = $applicationSkills ?? [];
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Application Skills

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.application.application-skill.table', [
        'applicationId'     => $application['id'],
        'applicationSkills' => $applicationSkills
    ])

</div>
