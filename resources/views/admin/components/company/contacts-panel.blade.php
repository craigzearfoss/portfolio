@php
$contacts = $contacts ?? [];//dd($contacts);
$addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h2 class="subtitle">

        Contacts

        @if(!empty($company))

            @include('admin.components.link', [
                'name'  => 'Add a Contact',
                'href'  => route('admin.career.company.contact.add', $company),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add a contact',
                'icon'  => 'fa-plus'
            ])

        @endif

    </h2>

    @include('admin.components.company.contacts-table', [
        'contacts' => $contacts ?? []
    ])

</div>
