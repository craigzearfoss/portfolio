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

            <div class="floating-div has-background-white-ter card p-4 m-2">

                @include('admin.components.show-row-link', [
                    'name'   => !empty($application->link_name) ? htmlspecialchars($application->link_name) : 'link',
                    'href'   => $application->link,
                    'target' => '_blank'
                ])

                @if (!empty($application->link2))
                    @include('admin.components.show-row-link', [
                        'name'   => !empty($application->link2_name) ? htmlspecialchars($application->link2_name) : 'link 2',
                        'href'   => $application->link2,
                        'target' => '_blank'
                    ])
                @endif

            </div>

        </div>
        <div class="floating-div card has-background-white-ter p-4 m-2">

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $parsedDescription
            ])

        </div>

    </div>

</div>
