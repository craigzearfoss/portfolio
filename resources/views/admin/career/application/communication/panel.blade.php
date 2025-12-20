@php
    $communications = $communications ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Communications

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Edit communications',
                'href'  => route('admin.career.communication.index', ['application_id' => $application->id]),
                'class' => 'button is-primary is-small px-1 py-0 mr-2',
                'title' => 'edit communications',
                'icon'  => 'fa-pen-to-square'
            ])

            @include('admin.components.link', [
                'name'  => 'Add a communication',
                'href'  => route('admin.career.communication.create', ['application_id' => $application->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add communication',
                'icon'  => 'fa-plus'
            ])

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.application.communication.table', [
        'communications' => $communications
    ])

</div>
