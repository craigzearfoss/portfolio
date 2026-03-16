@php
    use App\Models\System\AdminDatabase;
@endphp

@if($user)

    @php
        $portfolioResourceTypes = AdminDatabase::getResourceTypes(
            $user->id,
            'portfolio',
            [
                'is_public'   => 1,
                'is_disabled' => 0,
            ],
        );

        $personalResourceTypes = AdminDatabase::getResourceTypes(
            $user->id,
            'personal',
            [
                'is_public'   => 1,
                'is_disabled' => 0,
            ],
        );
    @endphp

    <div class="card column p-4 mb-2">

        <div class="columns">

            <div class="column is-one-third pt-0">

                @include('user.components.image', [
                    'name'     => 'image',
                    'src'      => $user->image,
                    'alt'      => $user->name,
                    'width'    => '200px',
                    'filename' => generateDownloadFilename($admin)
                ])

                <div class="show-container p-4">

                    <div class="columns">
                        <span class="column is-12 has-text-centered">
                            @include('user.components.link', [
                                'name'   => 'Resume',
                                'href'   => route('guest.resume', $admin),
                                'class'  => 'button is-primary is-small px-1 py-0',
                                'target' => '_blank',
                                'title'  => 'Resume',
                            ])
                        </span>
                    </div>

                    @if(!empty($user->role))
                        @include('user.components.show-row', [
                            'name'  => 'role',
                            'value' => $admin->role ?? ''
                        ])
                    @endif

                    @if(!empty($user->employer))
                        @include('user.components.show-row', [
                            'name'  => 'employer',
                            'value' => '<br>' . $user->employer ?? ''
                        ])
                    @endif

                    @if(!empty($user->bio))
                        @include('user.components.show-row', [
                            'name'  => 'bio',
                            'value' => $admin->bio ?? ''
                        ])
                    @endif

                </div>

            </div>

            </div>

        </div>

    </div>
@endif
