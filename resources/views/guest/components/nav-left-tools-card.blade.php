@php
    $toolItems = $toolItems ?? [];
@endphp
@if (!empty($toolItems))

    <div class="tools-left-nav-container card">

        @if (!empty($toolItems))

            @for ($i = 0; $i < count($toolItems); $i++)

                <ul class="menu is-menu-main">

                    @if ((get_class($toolItems[$i]) === 'stdClass') && $toolItems[$i]->name === 'Resume')

                        <p class="menu-label menu-label-left">
                            @include('guest.components.nav-link-left', [
                                'level'  => 1,
                                'name'   => $toolItems[$i]->title,
                                'href'   => !empty($toolItems[$i]->url) ? $toolItems[$i]->url: false,
                                'active' => $toolItems[$i]->active,
                                'class'  => 'button',
                            ])
                        </p>

                    @else

                        <p class="menu-label menu-label-left">
                            @include('guest.components.nav-link-left', [
                                'level'  => 1,
                                'name'   => $toolItems[$i]->title,
                                'href'   => !empty($toolItems[$i]->url) ? $toolItems[$i]->url: false,
                                'active' => $toolItems[$i]->active,
                            ])
                        </p>

                    @endif

                    @if (!empty($toolItems[$i]->children))

                        <ul class="menu-list pl-2" style="margin-left: 1em;">

                            @foreach ($toolItems[$i]['children'] as $l2=>$menu2Item)
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
