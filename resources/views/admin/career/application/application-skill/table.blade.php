@php
    $application       = $application ?? null;
    $applicationSkills = $applicationSkills ?? [];
@endphp

<div>

    @foreach ($applicationSkills as $applicationSkill)

        <div style="display: inline-block; width: 10rem;">

            <div style="display: inline-block;">
                <input type="hidden" name="application_skill[}]" value="0">
                <input type="checkbox"
                       data-application_skill_id="{{ $applicationSkill['id'] }}"
                       data-application_id="{{ $applicationSkill['application_id'] }}"
                       data-name="{{ $applicationSkill['name'] }}"
                       data-portfolio_skill_id="{{ $applicationSkill['id'] }}"
                       name="application_skill[]"
                       value="1"
                       class="application-skill-checkbox form-check-input "
                       {{ $applicationSkill['found'] ? 'checked' : '' }}
                >
            </div>
            <span>{{ $applicationSkill['name'] }}</span>

        </div>

    @endforeach

</div>

<div class="p-4">

    <div class="box m-4" style="max-width: 80rem;">
        {!! $application->description !!}
    </div>

</div>
