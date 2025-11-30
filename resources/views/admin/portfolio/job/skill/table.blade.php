@php
    $skills = $skills ?? [];
@endphp
<table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
    <thead>
    <th>name</th>
    <th>level</th>
    <th>start year</th>
    <th>end year</th>
    <th>years</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($skills as $skill)

        <tr>
            <td>
                {{ $skill->name ?? '' }}
            </td>
            <td>
                @include('admin.components.star-ratings', [
                    'rating' => $skill->level ?? 1,
                    'label'  => null
                ])

                {{ $skill->level ?? '' }}
            </td>
            <td>
                {{ $skill->start_year ?? '' }}
            </td>
            <td>
                {{ $skill->end_year ?? '' }}
            </td>
            <td>
                {{ $skill->years ?? '' }}
            </td>
            <td class="is-1" style="white-space: nowrap;">

                <a title="show" class="button is-small px-1 py-0"
                       href="{{ route('admin.portfolio.job-skill.show', $skill) }}">
                    <i class="fa-solid fa-list"></i>{{-- show --}}
                </a>

                <a title="edit" class="button is-small px-1 py-0"
                   href="{{ route('admin.portfolio.job-skill.edit', $skill) }}">
                    <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                </a>

                <button title="remove" type="submit" class="button is-small px-1 py-0">
                    <i class="fa-solid fa-trash"></i>{{-- delete --}}
                </button>

            </td>
        </tr>

    @endforeach

    </tbody>
</table>
