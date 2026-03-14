@php
    $skills = $skills ?? [];
@endphp
<table class="table admin-table skill-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>name</th>
    <th>category</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($skills as $skill)

        <tr>
            <td data-field="name">
                {!! $skill->name !!}
            </td>
            <td data-field="dictionary_category_id">
                 @if(!empty($skill->category->name))
                     {!! $skill->category->name !!}
                 @endif
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($skill, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.portfolio.job-skill.show', [
                                                   $skill,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($skill, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.portfolio.job-skill.edit', [
                                                   $skill,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($skill, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.portfolio.job-skill.destroy', $skill) !!}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            @include('admin.components.button-icon', [
                                'title' => 'delete',
                                'class' => 'delete-btn',
                                'icon'  => 'fa-trash'
                            ])
                        </form>
                    @endif

                </div>

            </td>
        </tr>

    @endforeach

    </tbody>
</table>
