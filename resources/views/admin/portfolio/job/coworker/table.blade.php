@php
    $coworkers = $coworkers ?? [];
@endphp
<table class="table admin-table coworker-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>name</th>
    <th style="min-width: 6em;">title</th>
    <th>level</th>
    <th>phone</th>
    <th>email</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($coworkers as $coworker)

        <tr>
            <td>
                @include('admin.components.link', [
                    'name' => $coworker->name,
                    'href' => route('admin.portfolio.job-coworker.show', $coworker)
                ])
            </td>
            <td data-field="title">
                {!! $coworker->title !!}
            </td>
            <td data-field="level">
                {!! $coworker->level !!}
            </td>
            <td data-field="phone">
                {!! $coworker->phone !!}
            </td>
            <td data-field="email">
                {!! $coworker->email !!}
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($coworker, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.portfolio.job-coworker.show', [
                                                   $coworker,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($coworker, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.portfolio.job-coworker.edit', [
                                                   $coworker,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($coworker, $admin))
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
