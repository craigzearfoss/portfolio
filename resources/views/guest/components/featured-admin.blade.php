@php
    use App\Enums\EnvTypes;
    use App\Models\System\AdminDatabase;
    use App\Models\System\AdminResource;
    use App\Models\System\Database;
@endphp

@if($featuredAdmin)

    @php
        $filters = [
            'has_owner'   => true,
            'menu'        => 1,
            'is_public'   => true,
            'is_disabled' => false,
        ];

        $resourcesByDatabase = new AdminResource()->ownerResourcesByDatabase(
            $featuredAdmin->id,
            EnvTypes::GUEST,
            null,
            $filters
        );
    @endphp

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('guest.components.image', [
                'name'     => 'image',
                'src'      => $featuredAdmin->image,
                'alt'      => $featuredAdmin->name,
                'width'    => '200px',
                'filename' => generateDownloadFilename($featuredAdmin)
            ])

            <div class="show-container p-4">

                <div class="columns">
                        <span class="column is-12 has-text-centered">
                            @include('guest.components.link', [
                                'name'   => 'Resume',
                                'href'   => route('guest.resume', $featuredAdmin),
                                'class'  => 'button is-primary is-small px-1 py-0',
                                'target' => '_blank',
                                'title'  => 'Resume',
                            ])
                        </span>
                </div>


                @if(!empty($featuredAdmin->role))
                    <p class="has-text-centered has-text-weight-bold mb-0">{!! $featuredAdmin->role !!}</p>
                @endif

                @if(!empty($featuredAdmin->employer))
                    <p class="has-text-centered has-text-weight-semibold mb-0">
                        {!! $featuredAdmin->employer !!}
                        @if($featuredAdmin->employment_status_id == 6)
                            (contracting)
                        @endif
                    </p>

                @elseif($featuredAdmin->employment_status_id == 7)
                    <p class="has-text-centered mb-0">self-employed</p>
                @endif

                @if(in_array($featuredAdmin->employment_status_id, [2, 3, 4]))
                    <p class="has-text-centered m-1">
                        <span class="has-background-success has-text-weight-semibold has-text-warning p-1 pl-2 pr-2">
                            Open to Work
                        </span>
                    </p>

                @endif

                @if(!empty($featuredAdmin->bio))
                    <p>{!! $featuredAdmin->bio !!}</p>
                @endif

            </div>

        </div>

        @foreach($resourcesByDatabase as $database)

            <div class="show-container card floating-div">

                <h2 class="has-text-weight-bold">{{ $database['name'] }}</h2>

                <div class="list is-hoverable">

                    @include('guest.components.resource-list', [
                        'resourceType' => dbName('portfolio_db'),
                        'resources'    => $database['resources'],
                        'admin'        => $featuredAdmin,
                    ])

                </div>

            </div>

        @endforeach

    </div>






<?php /*
    <div class="card column p-4 mb-2">

        <div class="columns">

            <div class="column is-one-third pt-0">

                @include('guest.components.image', [
                    'name'     => 'image',
                    'src'      => $featuredAdmin->image,
                    'alt'      => $featuredAdmin->name,
                    'width'    => '200px',
                    'filename' => generateDownloadFilename($featuredAdmin)
                ])

                <div class="show-container p-4">

                    <div class="columns">
                        <span class="column is-12 has-text-centered">
                            @include('guest.components.link', [
                                'name'   => 'Resume',
                                'href'   => route('guest.resume', $featuredAdmin),
                                'class'  => 'button is-primary is-small px-1 py-0',
                                'target' => '_blank',
                                'title'  => 'Resume',
                            ])
                        </span>
                    </div>

                    @if(!empty($featuredAdmin->role))
                        @include('guest.components.show-row', [
                            'name'  => 'role',
                            'value' => $featuredAdmin->role ?? ''
                        ])
                    @endif

                    @if(!empty($featuredAdmin->employer))
                        @include('guest.components.show-row', [
                            'name'  => 'employer',
                            'value' => '<br>' . $featuredAdmin->employer ?? ''
                        ])
                    @endif

                    @if(!empty($featuredAdmin->bio))
                        @include('guest.components.show-row', [
                            'name'  => 'bio',
                            'value' => $featuredAdmin->bio
                        ])
                    @endif

                </div>

            </div>

            <div class="column is-two-thirds pt-0">

                <div>

                    <h1 class="title is-size-5 mt-2 mb-0">Portfolio</h1>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($portfolioResourceTypes as $resourceType)

                            @if(Route::has('guest.admin.portfolio.'.$resourceType['name'].'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name'  => $resourceType['plural'],
                                        'href'  => route('guest.portfolio.'.$resourceType['name'].'.index', $featuredAdmin),
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

                            @if(Route::has('guest.admin.personal.'.$resourceType['name'].'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name'  => $resourceType['plural'],
                                        'href'  => route('guest.personal.'.$resourceType['name'].'.index', $featuredAdmin),
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
*/ ?>

 @endif
