@if($admin)

    @php
        $portfolioResourceTypes = \App\Models\System\AdminDatabase::getResourceTypes(
            $admin->id,
            'portfolio',
            [
                'public'   => 1,
                'disabled' => 0,
            ],
        );

        $personalResourceTypes = \App\Models\System\AdminDatabase::getResourceTypes(
            $admin->id,
            'personal',
            [
                'public'   => 1,
                'disabled' => 0,
            ],
        );
    @endphp

    <div class="card column p-4 mb-2">

        <div class="columns">

            <div class="column is-one-third pt-0">

                @include('admin.components.image', [
                    'name'     => 'image',
                    'src'      => $admin->image,
                    'alt'      => $admin->name,
                    'width'    => '200px',
                    'filename' => getFileSlug($admin->name, $admin->image)
                ])

                <div class="show-container p-4">

                    <div class="columns">
                        <span class="column is-12 has-text-centered">
                            @include('admin.components.link', [
                                'name'   => 'Resume',
                                'href'   => route('admin.admin.resume', $admin),
                                'class'  => 'button is-primary is-small px-1 py-0',
                                'target' => '_blank',
                                'title'  => 'Resume',
                            ])
                        </span>
                    </div>

                    @if(!empty($admin->role))
                        @include('admin.components.show-row', [
                            'name'  => 'role',
                            'value' => $admin->role ?? ''
                        ])
                    @endif

                    @if(!empty($admin->employer))
                        @include('admin.components.show-row', [
                            'name'  => 'employer',
                            'value' => '<br>' . $admin->employer ?? ''
                        ])
                    @endif

                    @if(!empty($admin->bio))
                        @include('admin.components.show-row', [
                            'name'  => 'bio',
                            'value' => $admin->bio ?? ''
                        ])
                    @endif

                </div>

            </div>

            <div class="column is-two-thirds pt-0">

                <div>

                    <h1 class="title is-size-5 mt-2 mb-0">Portfolio</h1>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($portfolioResourceTypes as $resourceType)

                            @if(empty($resourceType['global']) && Route::has('admin.admin.portfolio.'.$resourceType['name'].'.index'))
                                <li>
                                    @include('admin.components.link', [
                                        'name'  => $resourceType['plural'],
                                        'href'  => route('admin.admin.portfolio.'.$resourceType['name'].'.index', $admin),
                                        'class' => 'pt-1 pb-1',
                                    ])
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>

                <div>

                    <h1 class="title is-size-5 mt-2 mb-0">Personal</h1>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($personalResourceTypes as $resourceType)

                            @if(empty($resourceType['global']) && Route::has('admin.admin.personal.'.$resourceType['name'].'.index'))
                                <li>
                                    @include('admin.components.link', [
                                        'name'  => $resourceType['plural'],
                                        'href'  => route('admin.admin.personal.'.$resourceType['name'].'.index', $admin),
                                        'class' => 'pt-1 pb-1',
                                    ])
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    </div>
@endif
