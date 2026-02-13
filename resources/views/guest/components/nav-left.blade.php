@if($menuItems = $menuService->leftMenu())

    @php
        $menuService      = $menuService ?? null;
        $currentRouteName = $currentRouteName ??  Route::currentRouteName();
        $admin            = $admin ?? null;
        $user             = $user ?? null;
        $owner            = $owner ?? null;
    @endphp

    <aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
        <div class="aside-tools">
            <div class="aside-tools-label has-text-left" style="width: 100%;">

                @include('admin.components.button-home', [
                    'name'     => 'Home',
                    'href'     => route('guest.index'),
                    'selected' => true,
                ])

                <span>&nbsp;&nbsp;&nbsp;</span>

                @include('admin.components.button-home', [
                    'name'     => 'Admin',
                    'href'     => route('admin.dashboard'),
                    'selected' => false,
                ])

            </div>
        </div>

        <div class="control ml-2 mt-2">

            @if(\App\Models\System\Admin::where('public', 1)->count() > 1)

                <div class="has-text-light">candidates</div>

                @include('guest.components.form-select-nolabel', [
                    'value'    => !empty($owner->label) ? $owner->label : '',
                    'list'     => \App\Models\System\Admin::listOptions(
                                      [ 'public' => 1 ],
                                      'label',
                                      'name',
                                      true,
                                      false,
                                      ['name', 'asc']
                                  ),
                    'style'    => 'font-size: 1.1rem; font-weight: 700',
                    'onchange' => "document.location.href='/'+this.value;"
                ])

            @endif

        </div>

        @for ($i = 0; $i < count($menuItems); $i++)

            <ul class="menu is-menu-main" style="font-size: 1rem;">

                <p class="menu-label menu-label-left">
                    @include('guest.components.nav-link-left', [
                        'level'  => 1,
                        'name'   => $menuItems[$i]->title,
                        'href'   => !empty($menuItems[$i]->url) ? $menuItems[$i]->url: false,
                        'active' => $menuItems[$i]->active,
                        'class'  => 'has-text-white'
                    ])
                </p>

                @if(!empty($menuItems[$i]->children))

                    <ul class="menu-list pl-2" style="margin-left: 1em;">

                        @foreach ($menuItems[$i]['children'] as $l2=>$menu2Item)
                            <li>
                                @include('guest.components.nav-link-left', [
                                    'level'  => 2,
                                    'name'   => !empty($menu2Item->plural) ? $menu2Item->plural : $menu2Item->title,
                                    'href'   => !empty($menu2Item->url) ? $menu2Item->url : false,
                                    'active' => $menu2Item->active,
                                    'icon'   => !empty($menu2Item->icon) ? $menu2Item->icon : 'fa-circle'
                                ])

                                @if(!empty($menu2Item->children))
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

    </aside>

@endif
