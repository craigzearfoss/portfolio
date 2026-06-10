@php
    $resourceItems = $resourceItems ?? [];
@endphp
@if (!empty($resourceItems))

    <div class="resources-left-nav-container card">

        @if (!empty($resourceItems))

            @for ($i = 0; $i < count($resourceItems); $i++)

                <ul class="menu is-menu-main">

                    @if ((get_class($resourceItems[$i]) === 'stdClass') && $resourceItems[$i]->name === 'Resume')

                        <p class="menu-label menu-label-left">
                            @include('guest.components.nav-link-left', [
                                'level'  => 1,
                                'name'   => $resourceItems[$i]->title,
                                'href'   => !empty($resourceItems[$i]->url) ? $resourceItems[$i]->url: false,
                                'active' => $resourceItems[$i]->active,
                                'class'  => 'button',
                            ])
                        </p>

                    @else

                        <p class="menu-label menu-label-left">
                            @include('guest.components.nav-link-left', [
                                'level'  => 1,
                                'name'   => $resourceItems[$i]->title,
                                'href'   => !empty($resourceItems[$i]->url) ? $resourceItems[$i]->url: false,
                                'active' => $resourceItems[$i]->active,
                            ])
                        </p>

                    @endif

                    @if (!empty($resourceItems[$i]->children))

                        <ul class="menu-list pl-2" style="margin-left: 1em;">

                            @foreach ($resourceItems[$i]['children'] as $l2=>$menu2Item)
                                <li>
                                    @include('guest.components.nav-link-left', [
                                        'level'  => 2,
                                        'name'   => !empty($menu2Item->plural) ? $menu2Item->plural : $menu2Item->title,
                                        'href'   => !empty($menu2Item->url) ? $menu2Item->url : false,
                                        'active' => $menu2Item->active,
                                        'icon'   => !empty($menu2Item->icon) ? $menu2Item->icon : 'fa-circle'
                                    ])

                                    @if (!empty($menu2Item->children))
                                        @php dd($menu2Item->children) @endphp
                                        @php //@TODO: This isn't working @endphp
                                        <ul class="menu-list pl-2" style="margin-left: 1em;">

                                            @foreach ($menu2Item->children as $menu3Item)
                                                <li>
                                                    @include('guest.components.nav-link-left', [
                                                        'level'  => 3,
                                                        'name'   => !empty($menu3Item->plural) ? $menu3Item->plural : $menu3Item->title,
                                                        'href'   => !empty($menu3Item->url) ? $menu3Item->url : false,
                                                        'active' => $menu3Item->active,
                                                        'icon'   => !empty($menu3Item->icon) ? $menu3Item->icon : 'fa-circle'
                                                    ])
                                                </li>
                                            @endforeach

                                        </ul>

                                    @endif

                                </li>
                            @endforeach

                        </ul>

                    @endif

                </ul>

            @endfor

        @endif

    </div>

@endif
