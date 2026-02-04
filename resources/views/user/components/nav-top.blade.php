@if($menuItems = $menuService->topMenu())

    @php
        $menuService      = $menuService ?? null;
        $currentRouteName = $currentRouteName ??  Route::currentRouteName();
        $loggedInAdmin    = $loggedInAdmin ?? null;
        $loggedInUser     = $loggedInUser ?? null;
        $admin            = $admin ?? null;
        $user             = $user ?? null;
        $isAdminEnv       = (explode('.', $currentRouteName)[0] == 'admin');
    @endphp

    <nav id="navbar-main" class="navbar is-fixed-top">
        <div class="navbar-brand">

            @include('user.components.nav-link-top', [
                'name'   => false,
                'href'   => false,
                'class'  => 'is-hidden-desktop jb-aside-mobile-toggle',
                'icon'   => '<span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>'
            ])

            <div class="navbar-item has-control">

                <span class="mr-4 has-text-primary" style=" font-size: 1.5em; font-weight: 800;">
                    {{ config('app.name') }}
                </span>

                @if(isDemo())
                    <span class="ml-4 p-2 pr-4 pl-4 has-background-info has-text-white-bis" style="font-weight: 700;">
                        Demo Mode
                    </span>
                @elseif(boolval(config('app.readonly')))
                    <span class="ml-4 p-2 pr-4 pl-4 has-background-info has-text-white-bis" style="font-weight: 700;">
                        Site is Read-only
                    </span>
                @endif

            </div>
        </div>
        <div class="navbar-brand is-right">

            @include('user.components.nav-link-top', [
                'name'       => false,
                'href'       => false,
                'class'      => 'is-hidden-desktop jb-navbar-menu-toggle',
                'icon'       => '<span class="icon"><i class="mdi mdi-dots-vertical"></i></span>',
                'dataTarget' => 'navbar-menu'
            ])

        </div>

        @if (!in_array($currentRouteName, ['user.login', 'user.login-submit']))

            <div class="navbar-menu fadeIn animated faster" id="navbar-menu">
                <div class="navbar-end">

                    @foreach($menuItems as $menuItem)

                        @if($menuItem->name == 'user-dropdown')

                            <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider has-user-avatar is-hoverable" style="width: 12em;">

                                @php
                                    $name = '';
                                    if (!empty($menuItem->thumbnail)) {
                                        $name .= '<div class="is-user-avatar"><img src="'.$menuItem->thumbnail.'" alt="'.$menuItem->title.'"></div>';
                                    }
                                    $name .= '<div class="is-user-name"><span>'.$menuItem->title.'</span></div>';
                                    if (!empty($menuItem->icon)) {
                                        $name .= '<span class="text-xl"><i class="fa-solid '.$menuItem->icon.'"></i>';
                                    }
                                @endphp

                                @include('user.components.nav-link-top', [
                                    'name'       => $name,
                                    'href'       => false,
                                    'class'      => 'navbar-link is-arrowless',
                                    'icon'       => false
                                ])

                                @if (!empty($menuItem->children))
                                    <div class="navbar-dropdown">

                                        @foreach($menuItem->children as $menuSubItem)
                                            @include('user.components.nav-link-top', [
                                                'name'   => (!empty($menuSubItem->plural) ? $menuSubItem->plural : $menuSubItem->title),
                                                'href'   => !empty($menuSubItem->url) ? $menuSubItem->url : false,
                                                'active' => $menuSubItem->active,
                                                'icon'   => !empty($menuSubItem->icon) ? $menuSubItem->icon : 'fa-circle'
                                            ])
                                        @endforeach

                                    </div>
                                @endif

                            </div>

                        @else

                            <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider is-hoverable">

                                @include('user.components.nav-link-top', [
                                    'name'   => $menuItem->title,
                                    'href'   => $menuItem->url ?? false,
                                    'class'  => 'navbar-link is-arrowless',
                                    'icon'   => ''
                                ])

                                @if(!empty($menuItem->children))

                                    <div class="navbar-dropdown">

                                        @foreach($menuItem->children as $menuSubItem)
                                            @include('user.components.nav-link-top', [
                                                'name'   => !empty($menuSubItem->plural) ? $menuSubItem->plural : $menuSubItem->title,
                                                'href'   => !empty($menuSubItem->url) ? $menuSubItem->url : false,
                                                'active' => $menuSubItem->active,
                                                'icon'   => !empty($menuSubItem->icon) ? $menuSubItem->icon : 'fa-circle'
                                            ])
                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        @endif

                    @endforeach

                </div>
            </div>

        @endif

    </nav>

@endif
