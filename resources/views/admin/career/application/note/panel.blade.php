@php
    $notes = $notes ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Notes

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Edit notes',
                'href'  => route('admin.career.note.index', ['application_id' => $application->id]),
                'class' => 'button is-primary is-small px-1 py-0 mr-2',
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

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.application.note.table', [
        'notes' => $notes
    ])

</div>
