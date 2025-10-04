@php
    $coworkers = $coworkers ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h2 class="subtitle">

        Coworkers

        @if(!empty($company))

            @include('admin.components.link', [
                'name'  => 'Add a Coworker',
                'href'  => '',/*route('admin.portfolio.job.coworker.add', $company),*/
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add a coworker',
                'icon'  => 'fa-plus'
            ])

        @endif

    </h2>

    @include('admin.portfolio.job.coworker.table', [
        'coworkers' => $coworkers ?? []
    ])

</div>
