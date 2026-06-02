@php
    $contacts = $contacts ?? [];
    $addLink = $links['add'] ?? null;
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">

        Recruiting Firms

        <span style="display: inline-flex; float: right;">

            @if ($isRootAdmin)
                @include('admin.components.link', [
                    'name'  => 'Add a Recruiting Firm',
                    'href'  => route('admin.career.recruiter.create'),
                    'class' => 'button is-primary is-small px-1 py-0',
                    'title' => 'add a contact',
                    'icon'  => 'fa-plus'
                ])
            @endif

        </span>

    </h3>

    <hr class="navbar-divider">

    @include('admin.career.recruiter.recruiter.table', [
        'recruiters' => $recruiters
    ])

</div>
