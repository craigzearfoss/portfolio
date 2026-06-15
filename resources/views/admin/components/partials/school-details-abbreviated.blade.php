@php
    $separator = $separator ?? ' • ';

    $schoolDetails = [];;

    if (!empty($school)) {

        //if (!empty($school->gender)) $schoolDetails[] = $school->gender;
        if ($school->community_college) $schoolDetails[] = 'cc';
        if ($school->hbcu) $schoolDetails[] = 'hbcu';
        if ($school->technical) $schoolDetails[] = 'tech';
        if ($school->medical) $schoolDetails[] = 'med';
        if ($school->religious || !empty($school->religious_affiliation)) $schoolDetails[] = 'rel';
        if ($school->seminary) $schoolDetails[] = 'sem';

        if (!empty($areasOfStudy)) {
            $schoolDetails[] = '<div class="mb-2" style="display: inline-block;">' . implode(' • ', $areasOfStudy) . '</div>';
        }
    }
@endphp
@if (!empty($schoolDetails))
    {!! implode($separator, $schoolDetails) !!}
@endif
