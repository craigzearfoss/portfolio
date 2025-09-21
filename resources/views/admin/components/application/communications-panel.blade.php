@php
    $communications = $communications ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h2 class="subtitle">

        Communications

        @include('admin.components.link', [
            'name'  => 'Edit communications',
            'url'   => route('admin.career.communication.index', ['application_id' => $application->id]),
            'class' => 'button is-primary is-small px-1 py-0',
            'title' => 'edit communications',
            'icon'  => 'fa-pen-to-square'
        ])

        @include('admin.components.link', [
            'name'  => 'Add a communication',
            'url'   => route('admin.career.communication.create', ['application_id' => $application->id]),
            'class' => 'button is-primary is-small px-1 py-0',
            'title' => 'add communication',
            'icon'  => 'fa-plus'
        ])

    </h2>

    @include('admin.components.application.communications-table', [
        'communications' => $communications
    ])

</div>
