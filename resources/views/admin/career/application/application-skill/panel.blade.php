@php
    $application       = $application ?? null;
    $skills            = $skills ?? [];
    $antiSkills        = $antiSkills ?? [];
    $matchedSkills     = $matchedSkills ?? [];
    $matchedAntiSkills = $matchedAntiSkills ?? [];
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Application Skills

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.application.application-skill.table', [
        'application'       => $application,
        'skills'            => $skills ?? [],
        'antiSkills'        => $antiSkills ?? [],
        'matchedSkills'     => $matchedSkills ?? [],
        'matchedAntiSkills' => $matchedAntiSkills ?? [],
    ])

</div>
