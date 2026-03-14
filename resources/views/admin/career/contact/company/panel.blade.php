@php
    $companies = $companies ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Companies

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Add a Company',
                'href'  => route('admin.career.contact.company.add', $contact),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add a company',
                'icon'  => 'fa-plus'
            ])

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.contact.company.table', [
        'companies' => $companies
    ])

</div>
