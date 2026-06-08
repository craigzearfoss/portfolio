@php
    use App\Models\System\Owner;

    $admin = $admin ?? null;
    $user  = $user ?? null;
    $owner = $owner ?? null;

    $menItems       = [];
    $adminItems     = [];
    $candidateItems = [];
    $resourceItems  = [];

    if ($menuService ?? null) {
        $menuItems = $menuService->leftMenu();
    }

//dd($menuItems);
    if (empty($owner)) {
        $adminItems = $menuItems;
    } else {
        foreach ($menuItems as $menuItem) {
            if (
                (property_exists($menuItem, 'owner_id') && ($menuItem->owner_id == $owner->id))
                || (property_exists($menuItem, 'table') && in_array($menuItem->tag, [ 'personal_db', 'portfolio_db' ]))
            ) {
                $candidateItems[] = $menuItem;
            } else {//dd($menuItem, property_exists($menuItem, 'table'), in_array($menuItem->tag, [ 'personal_db', 'portfolio_db' ]));
                $adminItems[] =$menuItem;
            }
        }
    }
//dd($candidateItems, $adminItems);
@endphp
@if ($menuItems = $menuService->leftMenu())

    <aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
        <div class="aside-tools">
            <div class="aside-tools-label has-text-left has-text-centered" style="width: 100%;">

                @include('guest.components.button-home', [
                    'name'     => 'Home',
                    'href'     => route('guest.index'),
                    'selected' => true,
                ])

                @if (Auth::guard('admin')->check() || !config('app.single_admin_mode'))
                    <span class="home-admin-button-separator"></span>
                    @include('guest.components.button-home', [
                        'name'     => 'Admin',
                        'href'     => route('admin.dashboard'),
                        'selected' => false,
                    ])
                @endif

            </div>
        </div>

        <div class="candidate-left-nav-container card m-2 p-0 has-background-light-35 has-text-primary-dark">

            @if (!config('app.single_admin_mode'))

                <div class="card-header">
                    @include('guest.components.link', [
                        'name' => 'candidates',
                        'href' => route('guest.admin.index')
                    ])
                </div>
                <div class="select-container">
                    @include('guest.components.select-list', [
                        'value'       => !empty($owner->label) ? $owner->label : '',
                        'list'        => new Owner()->listOptions([ 'is_public' => 1, 'is_disabled' => false ], 'label', 'name', true, false, ['name', 'asc']),
                        'placeholder' => 'type name',
                        'onchange'    => 'loadSelectedAdmin(this.value, \'/#adminId#\')'
                    ])
                </div>

            @endif

            @if (!empty($candidateItems))

                @for ($i = 0; $i < count($candidateItems); $i++)

                    <ul class="menu is-menu-main" style="font-size: 1rem;">

                        @if ((get_class($candidateItems[$i]) === 'stdClass') && $candidateItems[$i]->name === 'Resume')

                            <p class="menu-label menu-label-left">
                                @include('guest.components.nav-link-left', [
                                    'level'  => 1,
                                    'name'   => $candidateItems[$i]->title,
                                    'href'   => !empty($candidateItems[$i]->url) ? $candidateItems[$i]->url: false,
                                    'active' => $candidateItems[$i]->active,
                                    'class'  => 'button is-primary',
                                    'style'  => 'width: 100%; height: 2em; color: #ffffff !important;',
                                ])
                            </p>

                        @else

                            <p class="menu-label menu-label-left">
                                @include('guest.components.nav-link-left', [
                                    'level'  => 1,
                                    'name'   => $candidateItems[$i]->title,
                                    'href'   => !empty($candidateItems[$i]->url) ? $candidateItems[$i]->url: false,
                                    'active' => $candidateItems[$i]->active,
                                    'class'  => 'has-text-white'
                                ])
                            </p>

                        @endif

                        @if (!empty($candidateItems[$i]->children))

                            <ul class="menu-list pl-2" style="margin-left: 1em;">

                                @foreach ($candidateItems[$i]['children'] as $l2=>$menu2Item)
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

        @for ($i = 0; $i < count($adminItems); $i++)

            <ul class="menu is-menu-main mb-2" style="font-size: 1rem;">

                @if ((get_class($adminItems[$i]) === 'stdClass') && $adminItems[$i]->name === 'Resume')

                    <p class="menu-label menu-label-left" style="margin-bottom: 1em !important;">
                        @include('guest.components.nav-link-left', [
                            'level'  => 1,
                            'name'   => $adminItems[$i]->title,
                            'href'   => !empty($adminItems[$i]->url) ? $adminItems[$i]->url: false,
                            'active' => $adminItems[$i]->active,
                            'class'  => 'button is-primary p-0 mt-1',
                            'style'  => 'width: 100%; height: 2em; color: #ffffff !important;',
                        ])
                    </p>

                @else

                    <p class="menu-label menu-label-left">
                        @include('guest.components.nav-link-left', [
                            'level'  => 1,
                            'name'   => $adminItems[$i]->title,
                            'href'   => !empty($adminItems[$i]->url) ? $adminItems[$i]->url: false,
                            'active' => $adminItems[$i]->active,
                            'class'  => 'has-text-white'
                        ])
                    </p>

                @endif

                @if (!empty($adminItems[$i]->children))

                    <ul class="menu-list pl-2" style="margin-left: 1em;">

                        @foreach ($adminItems[$i]['children'] as $l2=>$menu2Item)
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

    </aside>

@endif
