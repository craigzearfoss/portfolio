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
            <div class="aside-tools-label">

                @include('guest.components.link', [
                    'name'  => 'Home',
                    'href'  => route('guest.index'),
                    'class' => 'has-text-primary',
                    'style' => 'font-size: 1.2em; font-weight: 700; color: #ffe08a !important;',
                ])

                @if(isAdmin())

                    /

                    @include('guest.components.link', [
                        'name'  => 'Admin',
                        'href'  => route('admin.dashboard'),
                        'class' => 'has-text-primary',
                        'style' => 'font-size: 1.2em; font-weight: 700',
                    ])

                @endif

            </div>
        </div>

        <div class="control ml-2 mt-2">

            @if(\App\Models\System\Admin::where('public', 1)->count() > 1)

                @include('user.components.form-select-nolabel', [
                    'value'    => !empty($admin->label) ? $admin->label : '',
                    'list'     => \App\Models\System\Admin::listOptions([ 'public' => 1 ],
                                                                        'label',
                                                                        'name',
                                                                        true,
                                                                        false,
                                                                        [ 'name', 'asc']
                                                                       ),
                    'style'    => 'font-size: 1.1rem; font-weight: 700',
                    'onchange' => "document.location.href='/'+this.value;"
                ])

            @endif

        </div>

        @if (!in_array($currentRouteName, ['user.login', 'user.login-submit']))

            @for ($i = 0; $i < count($menuItems); $i++)

                <ul class="menu is-menu-main" style="font-size: 1rem;">

                    <p class="menu-label pb-0 mb-0">
                        <a @if (!empty($menuItems[$i]->url))href="{{ $menuItems[$i]->url }}" @endif
                           class="has-text-white {{ $menuItems[$i]->active ? 'is-active' : '' }}"
                           style="padding: 0.3rem;"
                        >
                            {{ $menuItems[$i]->title }}
                        </a>
                    </p>

                    @if(!empty($menuItems[$i]->children))

                        <ul class="menu-list pl-2" style="margin-left: 1em;">

                            @foreach ($menuItems[$i]['children'] as $l2=>$menu2Item)
                                <li>
                                    <a @if (!empty($menu2Item->url))href="{{ $menu2Item->url }}"  @endif
                                        class="{{ $menu2Item->active ? 'is-active' : '' }}"
                                       style="padding: 0.3rem;"
                                    >
                                        <div class="menu-item">
                                            <span class="text-xl">
                                                <i class="fa-solid {{ !empty($menu2Item->icon) ? $menu2Item->icon : 'fa-circle' }}"></i>
                                            </span>
                                            <span class="menu-item-label">
                                                {{ !empty($menu2Item->plural) ? $menu2Item->plural : $menu2Item->title }}
                                            </span>
                                        </div>
                                    </a>


                                    @if(!empty($menu2Item->children))
        @php //@TODO: This isn't working @endphp
                                        <ul class="menu-list pl-2" style="margin-left: 1em;">

                                            @foreach ($menu2Item->children as $menu3Item)
                                            <li>ffff
                                                <a @if (!empty($menu3Item->url))href="{{ $$menu3Item->url }}"  @endif
                                                class="{{ $menu3Item->active ? 'is-active' : '' }}"
                                                   style="padding: 0.3rem;"
                                                >
                                                    <div class="menu-item">
                                                    <span class="text-xl">
                                                        <i class="fa-solid {{ !empty($menu3Item->icon) ? $menu3Item->icon : 'fa-circle' }}"></i>
                                                    </span>
                                                        <span class="menu-item-label">
                                                        {{ !empty($menu3Item->plural) ? $menu3Item->plural : $menu3Item->title }}
                                                    </span>
                                                    </div>
                                                </a>

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

    </aside>

@endif
