@php
    $skills = $skills ?? [];
@endphp
<table class="table admin-table skill-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>name</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($skills as $skill)

        <tr>
            <td data-field="name">
                {!! $skill->name !!}
            </td>
            <td class="is-1" style="white-space: nowrap;">

                <a title="show" class="button is-small px-1 py-0"
                       href="{!! route('admin.portfolio.job-skill.show', $skill) !!}">
                    <i class="fa-solid fa-list"></i>
                </a>

                <a title="edit" class="button is-small px-1 py-0"
                   href="{!! route('admin.portfolio.job-skill.edit', $skill) !!}">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>

                <button title="remove" type="submit" class="button is-small px-1 py-0">
                    <i class="fa-solid fa-trash"></i>
                </button>

            </td>
        </tr>

    @endforeach

    </tbody>
</table>
