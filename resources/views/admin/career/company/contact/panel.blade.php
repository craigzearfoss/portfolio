@php
    $contacts = $contacts ?? [];//dd($contacts);
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Contacts

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Edit contacts',
                'href'  => route('admin.career.contact.index', ['company_id' => $company->id]),
                'class' => 'button is-primary is-small px-1 py-0 mr-2',
                'title' => 'edit contacts',
                'icon'  => 'fa-pen-to-square'
            ])

            @include('admin.components.link', [
                'name'  => 'Add a contact',
                'href'  => route('admin.career.contact.create', ['company_id' => $company->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add contact',
                'icon'  => 'fa-plus'
            ])

        </span>

    </h3>

    <hr class="navbar-divider mt-2">

    @include('admin.career.company.contact.table', [
        'contacts' => $contacts ?? []
    ])

</div>
