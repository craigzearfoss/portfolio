@php
    $application       = $application ?? null;
    $skills            = $skills ?? [];
    $antiSkills        = $antiSkills ?? [];
    $parsedDescription = $parsedDescription ?? '';
@endphp
<div class="card p-4">

    <h3 class="is-size-5 title mb-3">
        Description
    </h3>

    <div class="floating-div-container">

    <hr class="navbar-divider">

        <div class="floating-div-container">

            <div class="floating-div has-background-white-ter card p-4 m-2 no-x-scroll">

                @include('admin.components.show-row-link', [
                    'link_name' => 'link',
                    'name'      => $application->link,
                    'href'      => $application->link,
                    'target'    => '_blank',
                ])

                @include('admin.components.show-row', [
                    'name'  => 'link name',
                    'value' => $application->link_name,
                ])

                @include('admin.components.show-row-link', [
                    'link_name' => 'link2',
                    'name'      => $application->link2,
                    'href'      => $application->link2,
                    'target'    => '_blank',
                ])

                @include('admin.components.show-row', [
                    'name'  => 'link2 name',
                    'value' => $application->link2_name,
                ])

            </div>

        </div>
        <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" >

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $parsedDescription
            ])

        </div>

    </div>

</div>
