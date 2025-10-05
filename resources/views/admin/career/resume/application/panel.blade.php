@php
    $notes = $notes ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h2 class="subtitle">

        Applications

        @if(!empty($resume->id))

            @include('admin.components.link', [
                'name'  => 'Edit Applications',
                'href'  => route('admin.career.application.index', ['resume_id' => $resume->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'edit applications',
                'icon'  => 'fa-pen-to-square'
            ])

            @include('admin.components.link', [
                'name'  => 'Create a New Application',
                'href'  => route('admin.career.application.create', ['resume_id' => $resume->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add a new application',
                'icon'  => 'fa-plus'
            ])

        @endif

    </h2>

    @include('admin.career.resume.application.table', [
        'applications' => $applications
    ])

</div>
