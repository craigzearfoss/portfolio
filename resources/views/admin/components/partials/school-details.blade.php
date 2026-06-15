@php
    $separator = $separator ?? ' • ';

    $schoolDetails = [];;

    if (!empty($school)) {

        if (!empty($school->type)) $schoolDetails[] = "<strong>{$school->type}</strong>";
        if (!empty($school->gender)) $schoolDetails[] = "<strong>{$school->gender}</strong>";

        $histories = [];
        if (!empty($school->founded)) $histories[] = '<strong>founded:</strong> ' . $school->founded;
        if (!empty($school->closed)) $histories[] = '<strong>closed:</strong> ' . $school->closed;
        if (!empty($school->enrollment)) $histories[] = '<strong>enrollment:</strong> ' . number_format($school->enrollment);
        if (!empty($histories)) {
            $schoolDetails[] = '<div class="mb-2" style="display: inline-block;">' . implode($separator, $histories) . '</div>';
        }

        $areasOfStudy = [];
        if ($school->community_college) $areasOfStudy[] = '<strong>community college</strong>';
        if ($school->hbcu) $areasOfStudy[] = '<strong>hbcu</strong>';
        if ($school->technical) $areasOfStudy[] = '<strong>technical</strong>';
        if ($school->medical) $areasOfStudy[] = '<strong>medical</strong>';
        if ($school->seminary) $areasOfStudy[] = '<strong>seminary</strong>';
        if (!empty($areasOfStudy)) {
            $schoolDetails[] = '<div class="mb-2" style="display: inline-block;">' . implode($separator, $areasOfStudy) . '</div>';
        }

        $religion = null;
        if ($school->religious || !empty($school->religious_affiliation)) {
            if (!empty($school->religious_affiliation)) {
                        $religion = $school->religious_affiliation;
            } else {
                $religion = '<strong>religious</strong>';
            }
        }
        if (!empty($religion)) {
            $schoolDetails[] = '<div class="mb-2" style="display: inline-block;">' . $religion . '</div>';
        }
    }
@endphp
@if (!empty($schoolDetails))
    {!! implode('<br>', $schoolDetails) !!}
@endif
