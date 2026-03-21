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
            $featuredAdmin,
            EnvTypes::GUEST,
            null,
            [ 'has_owner' => true ]
        );
    @endphp

    <div class="floating-div">

        <div class="show-container card p-2 pl-4 pr-4 mb-2" style="width: auto;">

            <h2 class="title is-size-5 p-2 mb-0">{{ $title ?? 'Featured Candidate' }}</h2>

            <div class="show-container floating-div">

                @include('guest.components.image', [
                    'name'     => 'image',
                    'src'      => $featuredAdmin->image,
                    'alt'      => $featuredAdmin->name,
                    'width'    => '200px',
                    'filename' => generateDownloadFilename($featuredAdmin)
                ])

                <div class="show-container p-2">

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

                    <p class="has-text-centered is-size-5 has-text-weight-bold mb-0">
                        <strong>{!! $featuredAdmin->name !!}</strong>
                    </p>

                    @if(!empty($featuredAdmin->role))
                        <p class="has-text-centered has-text-weight-semibold mb-0">
                            <strong>{!! $featuredAdmin->role !!}</strong>
                        </p>
                    @endif

                    @if(!empty($featuredAdmin->employer))
                        <p class="has-text-centered has-text-weight-medium mb-0">
                            <strong>{!! $featuredAdmin->employer !!}
                                @if($featuredAdmin->employment_status_id == 6)
                                    (contracting)
                                @endif
                            </strong>
                        </p>
                    @elseif($featuredAdmin->employment_status_id == 7)
                        <p class="has-text-centered mb-0">
                            <strong>self-employed</strong>
                        </p>
                    @endif

                    @if(in_array($featuredAdmin->employment_status_id, [2, 3, 4]))
                        <p class="has-text-centered m-1">
                            <span class="has-background-success has-text-weight-semibold has-text-warning p-1 pl-2 pr-2">
                                <strong>Open to Work</strong>
                            </span>
                        </p>
                    @endif

                    @if(!empty($featuredAdmin->bio))
                        <p>
                            {!! $featuredAdmin->bio !!}
                        </p>
                    @endif

                </div>

            </div>

            @foreach($resourcesByDatabase as $database)

                @if (!empty($database['resources']))

                    <div class="show-container card floating-div">

                        <h2 class="has-text-weight-bold">{{ $database['title'] }}</h2>

                        <div class="list is-hoverable">

                            @include('guest.components.resource-list', [
                                'resourceType' => dbName('portfolio_db'),
                                'resources'    => $database['resources'],
                                'admin'        => $featuredAdmin,
                            ])

                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    </div>

 @endif
