@php
    $notes = $notes ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h2 class="subtitle">

        Notes

        @include('admin.components.link', [
            'name'  => 'Edit notes',
            'href'  => route('admin.career.note.index', ['application_id' => $application->id]),
            'class' => 'button is-primary is-small px-1 py-0',
            'title' => 'add note',
            'icon'  => 'fa-pen-to-square'
        ])

        @include('admin.components.link', [
            'name'  => 'Add a note',
            'href'  => route('admin.career.note.create', ['application_id' => $application->id]),
            'class' => 'button is-primary is-small px-1 py-0',
            'title' => 'add note',
            'icon'  => 'fa-plus'
        ])

    </h2>

    @include('admin.career.application.note.table', [
        'notes' => $notes
    ])

</div>
