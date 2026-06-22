@php
    $skills = $skills ?? [];
@endphp
<table class="table admin-table skill-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <tr>
        <th>name</th>
        <th>category</th>
        <th class="has-text-centered">public</th>
        <th class="has-text-centered">disabled</th>
        <th>actions</th>
    </tr>
    </thead>
    <tbody>

    @foreach ($skills as $skill)

        <tr data-id="{{ $skill->id }}" {!! $skill->is_disabled ? 'class="disabled-text"' : '' !!}>
            <td data-field="name" style="white-space: nowrap;">
                {!! $skill->name !!}
            </td>
            <td data-field="dictionary_category_id" style="white-space: nowrap;">
                 @if (!empty($skill->category->name))
                     {!! $skill->category->name !!}
                 @endif
            </td>
            <td data-field="is_public" class="has-text-centered">
                @include('admin.components.checkmark', [ 'checked' => $skill->is_public ])
            </td>
            <td data-field="is_disabled" class="has-text-centered">
                @include('admin.components.checkmark', [ 'checked' => $skill->is_disabled ])
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if (canRead($skill, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.portfolio.job-skill.show', [
                                                   $skill,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if (canUpdate($skill, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.portfolio.job-skill.edit', [
                                                   $skill,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if (canDelete($skill, $admin))
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
