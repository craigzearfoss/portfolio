@php
    $applications = $applications ?? [];
    $addLink      = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Contacts

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Add an application',
                'href'  => route('admin.career.application.create', ['company_id' => $company->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add an application',
                'icon'  => 'fa-plus'
            ])

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.company.application.table', [
        'applications' => $applications
    ])

</div>
