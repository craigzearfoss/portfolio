@php
    $events = $events ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h2 class="subtitle">

        Events

        @if(!empty($addLink))

            @include('admin.components.link', [
                'name'  => 'Edit events',
                'href'  => route('admin.career.event.index', ['application_id' => $application->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'edit events',
                'icon'  => 'fa-pen-to-square'
            ])

        @endif
    </h2>

    @include('admin.components.application.events-table', [
        'events' => $events
    ])

</div>
