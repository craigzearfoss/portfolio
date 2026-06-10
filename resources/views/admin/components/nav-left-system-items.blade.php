@php
    $systemItems = $systemItems ?? [];
    $owner       = $ownerr ?? null;
@endphp

@for ($i = 0; $i < count($systemItems); $i++)

    <ul class="menu hamburger-left-nav-system-container is-menu-main" style="font-size: 1rem;">

        @if ((get_class($systemItems[$i]) === 'stdClass') && $systemItems[$i]->name === 'Resume')

            <p class="menu-label menu-label-left" style="margin-bottom: 1em !important;">
                @include('admin.components.nav-link-left', [
                    'level'  => 1,
                    'name'   => $systemItems[$i]->title,
                    'href'   => !empty($systemItems[$i]->url) ? $systemItems[$i]->url: false,
                    'active' => $systemItems[$i]->active,
                    'class'  => 'button',
                ])
            </p>

        @else

            <p class="menu-label menu-label-left">
                @include('admin.components.nav-link-left', [
                    'level'  => 1,
                    'name'   => $systemItems[$i]->title,
                    'href'   => !empty($systemItems[$i]->url) ? $systemItems[$i]->url: false,
                    'active' => $systemItems[$i]->active,
                    'class'  => 'has-text-white'
                ])
            </p>

        @endif

        @if (!empty($systemItems[$i]->children))

            <ul class="menu-list pl-2" style="margin-left: 1em;">

                @foreach ($systemItems[$i]['children'] as $l2=>$menu2Item)
                    <li>
                        @include('admin.components.nav-link-left', [
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
                                        @include('admin.components.nav-link-left', [
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
