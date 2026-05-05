@php
    $coworkers = $coworkers ?? [];
@endphp
<table class="table admin-table coworker-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <tr>
        <th>name</th>
        <th style="min-width: 6em;">title</th>
        <th>level</th>
        <th>phone</th>
        <th>email</th>
        <th>public</th>
        <th>disabled</th>
        <th>actions</th>
    </tr>
    </thead>
    <tbody>

    @foreach ($coworkers as $coworker)

        <tr>
            <td data-field="id" style="white-space: nowrap;">
                @include('admin.components.link', [
                    'name' => $coworker->name,
                    'href' => route('admin.portfolio.job-coworker.show', $coworker)
                ])
            </td>
            <td data-field="title" style="white-space: nowrap;">
                {!! $coworker->title !!}
            </td>
            <td data-field="level" style="white-space: nowrap;">
                {!! $coworker->level !!}
            </td>
            <td data-field="phone" style="white-space: nowrap;">
                {!! $coworker->phone !!}
            </td>
            <td data-field="email" style="white-space: nowrap;">
                {!! $coworker->email !!}
            </td>
            <td data-field="is_public" class="has-text-centered">
                @include('admin.components.checkmark', [ 'checked' => $coworker->is_public ])
            </td>
            <td data-field="is_disabled" class="has-text-centered">
                @include('admin.components.checkmark', [ 'checked' => $coworker->is_disabled ])
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if (canRead($coworker, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.portfolio.job-coworker.show', [
                                                   $coworker,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if (canUpdate($coworker, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.portfolio.job-coworker.edit', [
                                                   $coworker,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if (canDelete($coworker, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.portfolio.job-coworker.destroy', $coworker) !!}"
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
