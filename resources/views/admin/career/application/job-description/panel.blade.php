<div class="card p-4">

    <h3 class="is-size-5 title mb-3">
        Description
    </h3>

    <hr class="navbar-divider">
    @include('admin.components.show-row-link', [
        'name'   => 'link',
        'href'   => $application->link,
        'target' => '_blank'
    ])

    @include('admin.components.show-row', [
        'name'   => 'link name',
        'label'  => 'link_name',
        'value'  => htmlspecialchars($application->link_name),
    ])

    @include('admin.components.show-row', [
        'name'  => 'description',
        'value' => $application->description
    ])

</div>
