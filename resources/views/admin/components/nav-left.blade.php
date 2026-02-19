@php
    $admin = $admin ?? null;
    $user  = $user ?? null;
    $owner = $owner ?? null;
@endphp
@if($menuItems = $menuService->leftMenu())

    <aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
        <div class="aside-tools">
            <div class="aside-tools-label has-text-left" style="width: 100%;">

                @include('admin.components.button-home', [
                    'name'     => 'Home',
                    'href'     => route('guest.index'),
                    'selected' => false,
                ])

                <span>&nbsp;&nbsp;&nbsp;</span>

                @include('admin.components.button-home', [
                    'name'     => 'Admin',
                    'href'     => route('admin.dashboard'),
                    'selected' => true,
                ])

            </div>
        </div>

        @if (!in_array(Route::currentRouteName(), ['admin.login', 'admin.login-submit']))

            @for ($i0 = 0; $i0 < count($menuItems); $i0++)

                <ul class="menu is-menu-main" style="font-size: 1rem;">

                    <p class="menu-label menu-label-left">
                        @include('admin.components.nav-link-left', [
                            'level'  => 1,
                            'name'   => $menuItems[$i0]->title,
                            'href'   => !empty($menuItems[$i0]->url) ? $menuItems[$i0]->url: false,
                            'active' => $menuItems[$i0]->active,
                            'class'  => 'has-text-white'
                        ])
                    </p>

                    @if($menu1Items = $menuItems[$i0]->children ?? [])

                        <ul class="menu-list pl-2" style="margin-left: 1em;">

                            @for ($i1 = 0; $i1 < count($menu1Items); $i1++)

                                <li>
                                    @include('admin.components.nav-link-left', [
                                        'level'  => 2,
                                        'name'   => !empty($menu1Items[$i1]->plural) ? $menu1Items[$i1]->plural : $menu1Items[$i1]->title,
                                        'href'   => !empty($menu1Items[$i1]->url) ? $menu1Items[$i1]->url: false,
                                        'active' => $menu1Items[$i1]->active,
                                        'active' => $menu1Items[$i1]->active,
                                        'icon'   => !empty($menu1Items[$i1]->icon) ? $menu1Items[$i1]->icon : 'fa-circle'
                                    ])

                                    @if($menu2Items = $menu1Items[$i1]->children ?? [])

                                        <ul class="menu-list pl-2" style="margin-left: 1em;">

                                            @for ($i2 = 0; $i2 < count($menu2Items); $i2++)

                                                <li>
                                                    @include('admin.components.nav-link-left', [
                                                        'level'  => 3,
                                                        'name'   => !empty($menu2Items[$i2]->plural) ? $menu2Items[$i2]->plural : $menu2Items[$i2]->title,
                                                        'href'   => !empty($menu2Items[$i2]->url) ? $menu2Items[$i2]->url: false,
                                                        'active' => $menu2Items[$i2]->active,
                                                        'active' => $menu2Items[$i2]->active,
                                                        'icon'   => !empty($menu2Items[$i2]->icon) ? $menu2Items[$i2]->icon : 'fa-circle'
                                                    ])
                                                </li>

                                            @endfor

                                        </ul>

                                    @endif

                                </li>

                            @endfor

                        </ul>

                    @endif

                </ul>

            @endfor

        @endif

    </aside>

@endif
