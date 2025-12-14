@if($admin)

    @php
        $portfolioResources = \App\Models\System\Database::getResources('portfolio', [], ['name', 'asc']);
    @endphp

    <div class="card column p-4 mb-2">

        <div class="columns">

            <div class="column is-one-third pt-0">

                @include('user.components.image', [
                    'name'     => 'image',
                    'src'      => $admin->image,
                    'alt'      => $admin->name,
                    'width'    => '200px',
                    'filename' => getFileSlug($admin->name, $admin->image)
                ])

                <div class="show-container p-4">

                    <div class="columns">
                        <span class="column is-12 has-text-centered">
                            @include('user.components.link', [
                                'name'   => 'Resume',
                                'href'   => route('guest.admin.resume', $admin),
                                'class'  => 'button is-primary is-small px-1 py-0',
                                'target' => '_blank',
                                'title'  => 'Resume',
                            ])
                        </span>
                    </div>

                    @if(!empty($admin->role))
                        @include('user.components.show-row', [
                            'name'  => 'role',
                            'value' => $admin->role ?? ''
                        ])
                    @endif

                    @if(!empty($admin->employer))
                        @include('user.components.show-row', [
                            'name'  => 'employer',
                            'value' => '<br>' . $admin->employer ?? ''
                        ])
                    @endif

                    @if(!empty($admin->bio))
                        @include('user.components.show-row', [
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

                        @foreach ($portfolioResources as $resource)

                            @if(empty($resource['global']) && Route::has('guest.admin.portfolio.'.$resource['name'].'.index'))
                                <li>
                                    @include('user.components.link', [
                                        'name'  => $resource['plural'],
                                        'href'  => route('guest.admin.portfolio.'.$resource['name'].'.index', $admin),
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
