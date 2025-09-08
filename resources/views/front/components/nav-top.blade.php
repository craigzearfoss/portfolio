@php
    $menuItems = (new \App\Services\MenuService())->getTopMenu(\App\Services\PermissionService::USER_TYPE_GUEST);
@endphp
<nav id="navbar-main" class="navbar is-fixed-top">
    <div class="navbar-brand">
        <a class="navbar-item is-hidden-desktop jb-aside-mobile-toggle">
            <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
        </a>
        <div class="navbar-item has-control">
            <div class="control"><input placeholder="Search everywhere..." class="input" fdprocessedid="c36wk"></div>
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

                    <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider has-user-avatar is-hoverable">
                        <a class="navbar-link is-arrowless">

                            @if (!empty($menuItem->thumbnail))
                                <div class="is-user-avatar">
                                    <img src="{{ $menuItem->thumbnail }}" alt="{{ $menuItem->title }}">
                                </div>
                            @endif

                            <div class="is-user-name"><span>{{ $menuItem->title }}</span></div>
                            @if(!empty($menuSubItem->icon))
                                <span class="text-xl">
                                    <i class="fa-solid {{ $menuSubItem->icon }}"></i>
                                </span>
                            @endif
                        </a>

                        @if (!empty($menuItem->children))
                            <div class="navbar-dropdown">

                                @foreach($menuItem->children as $menuSubItem)
                                    <a @if (!empty($menuSubItem->link))href="{{ $menuSubItem->link }}" @endif
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
                        <a class="navbar-link is-arrowless">
                            <span class="icon"><i class="mdi mdi-menu"></i></span>
                            <span>{{ $menuItem->title }}</span>
                            <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
                        </a>

                        @if(!empty($menuItem->children))
                            <div class="navbar-dropdown">
                                @foreach($menuItem->children as $menuSubItem)
                                    <a @if (!empty($menuSubItem->link))href="{{ $menuSubItem->link }}" @endif
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
