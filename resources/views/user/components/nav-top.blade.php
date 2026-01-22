@if($menuItems = $menuService->topMenu())

    @php
        $isAdminEnv = !empty($currentRouteName) && (explode('.', $currentRouteName)[0] == 'admin');
    @endphp

<nav id="navbar-main" class="navbar is-fixed-top">
    <div class="navbar-brand">
        <a class="navbar-item is-hidden-desktop jb-aside-mobile-toggle">
            <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
        </a>
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
        <a class="navbar-item is-hidden-desktop jb-navbar-menu-toggle" data-target="navbar-menu">
            <span class="icon"><i class="mdi mdi-dots-vertical"></i></span>
        </a>
    </div>

    <div class="navbar-menu fadeIn animated faster" id="navbar-menu">
        <div class="navbar-end">

            @foreach($menuItems as $menuItem)

                @if($menuItem->name == 'user-dropdown')

                    <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider has-user-avatar is-hoverable" style="width: 12em;">
                        <a class="navbar-link is-arrowless">

                            @if (!empty($menuItem->thumbnail))
                                <div class="is-user-avatar">
                                    <img src="{{ $menuItem->thumbnail }}" alt="{{ $menuItem->title }}">
                                </div>
                            @endif

                            <div class="is-user-name"><span>{{ $menuItem->title }}</span></div>
                            @if(!empty($menuItem->icon))
                                <span class="text-xl">
                                    <i class="fa-solid {{ $menuItem->icon }}"></i>
                                </span>
                            @endif
                        </a>

                        @if (!empty($menuItem->children))
                            <div class="navbar-dropdown">

                                @foreach($menuItem->children as $menuSubItem)
                                    <a @if (!empty($menuSubItem->url))href="{{ $menuSubItem->url }}" @endif
                                       class="navbar-item"
                                    >
                                        @if(!empty($menuSubItem->icon))
                                            <span class="text-xl">
                                                <i class="fa-solid {{ $menuSubItem->icon }}"></i>
                                            </span>
                                        @endif
                                        <span>{{ $menuSubItem->title }}</span>
                                    </a>
                                @endforeach

                            </div>
                        @endif

                    </div>


                @else

                    <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider is-hoverable">
                        <a @if(empty($menuItem->children) && !empty($menuItem->url))href="{{ $menuItem->url }}" @endif
                               class="navbar-link is-arrowless">
                            <span>{{ $menuItem->title }}</span>
                        </a>

                        @if(!empty($menuItem->children))
                            <div class="navbar-dropdown">
                                @foreach($menuItem->children as $menuSubItem)
                                    <a @if (!empty($menuSubItem->url))href="{{ $menuSubItem->url }}" @endif
                                        class="navbar-item"
                                    >
                                        @if(!empty($menuSubItem->icon))
                                            <span class="icon"><i class="fa-solid {{ $menuSubItem->icon }}"></i></span>
                                        @endif
                                        <span>{{ !empty($menuSubItem->plural) ? $menuSubItem->plural : $menuSubItem->title }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    </div>

                @endif

            @endforeach

        </div>
    </div>
</nav>
