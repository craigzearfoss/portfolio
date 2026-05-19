@php
    $application       = $application ?? null;
    $skills            = $skills ?? [];
    $antiSkills        = $antiSkills ?? [];
    $parsedDescription = $parsedDescription ?? '';
@endphp


<div class="card ml-0 mb-2">

    <div class="card-header p-2">
        <span class="has-text-weight-semibold">
            Skills
            <span class="is-size-6" style="font-weight: 400;"><i>({{ count($matchedSkills) }} {{ (count($matchedSkills) == 1) ? 'match' : 'matches' }} found.)</i></span>
        </span>
    </div>

    <div class="card-body p-2">

        @foreach ($skills as $skill)

            <div style="white-space: nowrap; width: 10rem; display: inline-block;">

                <div style="display: inline-block;">

                    @if (in_array($skill, $matchedSkills))
                        <i class="application-skill-checkbox-icon fa fa-check ml-2"></i>
                    @else
                        <i class="application-skill-checkbox-icon fa fa-square-o ml-2"></i>
                    @endif

                </div>
                <label for="checkBoxSkill_{{ Str::slug($skill) }}">
                    {{ $skill }}
                </label>

            </div>

        @endforeach

    </div>

</div>

<div class="card ml-0 mb-2">

    <div class="card-header p-2">
        <span class="has-text-weight-semibold">
            Anti-Skills
            <span class="is-size-6" style="font-weight: 400;"><i>({{ count($matchedAntiSkills) }} {{ (count($matchedAntiSkills) == 1) ? 'match' : 'matches' }}  found.)</i></span>
        </span>
    </div>

    <div class="card-body p-2">

        @foreach ($antiSkills as $antiSkill)

            <div style="display: inline-block; white-space: nowrap; width: 10rem;">

                <div style="display: inline-block;">

                    @if (in_array($antiSkill, $matchedAntiSkills))
                        <i class="application-anti-skill-checkbox-icon fa fa-check ml-2"></i>
                    @else
                        <i class="application-anti-skill-checkbox-icon fa fa-square-o ml-2"></i>
                    @endif

                </div>
                <label for="checkBoxAntiSkill_{{ Str::slug($antiSkill) }}">
                    {{ $antiSkill }}
                </label>

            </div>

        @endforeach

    </div>

</div>

<div class="card ml-0 mb-4">

    <div class="card-header p-2">
        <span class="has-text-weight-semibold">
            Job Description
        </span>
    </div>

    <div class="card-body p-2">
        {!! $parsedDescription !!}
    </div>

</div>
