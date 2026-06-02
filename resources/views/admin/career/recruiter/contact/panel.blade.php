@php
    $contacts = $contacts ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Contacts

        <span style="display: inline-flex; float: right;">

            @if (canCreate(Recruiter::class, $admin))
                @include('admin.components.link', [
                    'name'  => 'Add a Recruiting Contact',
                    'href'  => route('admin.career.contact.create', [ 'owner_id' => $admin->id, 'recruiter_id' => -1 ]),
                    'class' => 'button is-primary is-small px-1 py-0',
                    'title' => 'add a contact',
                    'icon'  => 'fa-plus'
                ])
            @endif

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.recruiter.contact.table', [
        'contacts' => $contacts
    ])

</div>
