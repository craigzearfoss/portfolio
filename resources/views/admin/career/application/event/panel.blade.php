@php
    $events = $events ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-1">

        Events

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Edit events',
                'href'  => route('admin.career.event.index', ['application_id' => $application->id]),
                'class' => 'button is-primary is-small px-1 py-0 mr-2',
                'title' => 'add event',
                'icon'  => 'fa-pen-to-square'
            ])

            @include('admin.components.link', [
                'name'  => 'Add an event',
                'href'  => route('admin.career.event.create', ['application_id' => $application->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add event',
                'icon'  => 'fa-plus'
            ])

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.application.event.table', [
        'events' => $events
    ])

</div>
