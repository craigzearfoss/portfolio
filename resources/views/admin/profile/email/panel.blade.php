@php
    $$emails = $emails ?? [];
    $addLink = $links['add'] ?? null
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Notes

        <span style="display: inline-flex; float: right;">

            @include('admin.components.link', [
                'name'  => 'Add an email address',
                'href'  => route('admin.system.admin-email.create', ['owner_id_id' => $admin->id]),
                'class' => 'button is-primary is-small px-1 py-0',
                'title' => 'add an email address',
                'icon'  => 'fa-plus'
            ])

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.profile.email.table', [
        'emails' => $$emails
    ])

</div>
