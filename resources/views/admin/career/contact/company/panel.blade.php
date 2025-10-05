@php
    $companies = $companies ?? [];//dd($companies);
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h2 class="subtitle">

        Companies

        @if(!empty($contact))

            @include('admin.components.link', [
                'name'  => 'Add a Company',
                'href'  => route('admin.career.contact.company.add', $contact),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add a company',
                'icon'  => 'fa-plus'
            ])

        @endif

    </h2>

    @include('admin.career.contact.company.table', [
        'companies' => $companies ?? []
    ])

</div>
