@php
    $menuItems = (new \App\Services\MenuService())->getTopMenu(
        \App\Services\PermissionService::ENV_USER,
        $admin ?? null
    );
@endphp
<nav id="navbar-main" class="navbar is-fixed-top">
    <div class="navbar-brand">
        <a class="navbar-item is-hidden-desktop jb-aside-mobile-toggle">
            <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
        </a>
        <div class="navbar-item has-control">
            <div class="control">
                <?php /*
                <input placeholder="Search everywhere..." class="input">
                */ ?>
            </div>
        </div>
    </div>
    <div class="navbar-brand is-right">
        <a class="navbar-item is-hidden-desktop jb-navbar-menu-toggle" data-target="navbar-menu">
            <span class="icon"><i class="mdi mdi-dots-vertical"></i></span>
        </a>
    </div>
    <div class="navbar-menu fadeIn animated faster" id="navbar-menu">
        <div class="navbar-end">
            <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider is-hoverable">
                <a class="navbar-link is-arrowless">
                    <span class="icon"><i class="mdi mdi-menu"></i></span>
                    <span>Sample Menu</span>
                    <span class="icon">
            <i class="mdi mdi-chevron-down"></i>
          </span>
                </a>
                <div class="navbar-dropdown">
                    <a href="profile.html" class="navbar-item">
                        <span class="icon"><i class="mdi mdi-account"></i></span>
                        <span>My Profile</span>
                    </a>
                    <a class="navbar-item">
                        <span class="icon"><i class="mdi mdi-settings"></i></span>
                        <span>Settings</span>
                    </a>
                    <a class="navbar-item">
                        <span class="icon"><i class="mdi mdi-email"></i></span>
                        <span>Messages</span>
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item">
                        <span class="icon"><i class="mdi mdi-logout"></i></span>
                        <span>Log Out</span>
                    </a>
                </div>
            </div>
            <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider has-user-avatar is-hoverable">
                <a class="navbar-link is-arrowless">
                    <div class="is-user-avatar">
                        <img src="https://avatars.dicebear.com/v2/initials/john-doe.svg" alt="John Doe">
                    </div>
                    <div class="is-user-name"><span>John Doe</span></div>
                    <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
                </a>
                <div class="navbar-dropdown">
                    <a href="profile.html" class="navbar-item">
                        <span class="icon"><i class="mdi mdi-account"></i></span>
                        <span>My Profile</span>
                    </a>
                    <a class="navbar-item">
                        <span class="icon"><i class="mdi mdi-settings"></i></span>
                        <span>Settings</span>
                    </a>
                    <a class="navbar-item">
                        <span class="icon"><i class="mdi mdi-email"></i></span>
                        <span>Messages</span>
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item">
                        <span class="icon"><i class="mdi mdi-logout"></i></span>
                        <span>Log Out</span>
                    </a>
                </div>
            </div>
            <a href="https://justboil.me/bulma-admin-template/free-html-dashboard/" title="About" class="navbar-item has-divider is-desktop-icon-only">
                <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
                <span>About</span>
            </a>
            <a title="Log out" class="navbar-item is-desktop-icon-only">
                <span class="icon"><i class="mdi mdi-logout"></i></span>
                <span>Log out</span>
            </a>
        </div>
    </div>
</nav>

<?php /*
<div class="side-nav side-nav-transparent side-nav-expand">
    <div class="side-nav-header">
        <div class="logo px-6">

            @if (Auth::guard('user'))
                <a href="{{ route('user.dashboard') }}">
                    <h4 style="margin: 10px 0; color: #222;">{{ config('app.name') }} Admin</h4>
                </a>
            @else
                <a href="{{ route('guest.index') }}">
                    <h4 style="margin: 10px 0; color: #222;">{{ config('app.name') }} Admin</h4>
                </a>
            @endif
        </div>

    </div>
    <div class="side-nav-content relative side-nav-scroll">
        <nav class="menu menu-transparent px-4 pb-4">

            <div class="menu-group">
                <ul>

                    @php
                        $currentSection = '';
                    @endphp
                    @foreach(\App\Models\Resource::all() as $i=>$resource)
                        @if ($resource->database['title'] != $currentSection)
                            @if (!empty($currentSection))
                                <li id="menu-item-portfolio" class="menu-item-divider"></li>
                            @endif
                            <div class="menu-title">{{ $resource->database['title'] }}</div>
                        @endif
                        @php
                            $currentSection = $resource->database['title'];
                        @endphp
                        <li class="menu-collapse">
                            <a @if (strpos(Route::currentRouteName(), 'user.' . $resource->type) !== 0)
                                   href="{{ route('user.' . $resource->type . '.index') }}"
                                @endif
                            >
                                <div class="menu-item {{ (strpos(Route::currentRouteName(), 'user.' . $resource->type) === 0) ? 'menu-item-active' : '' }}">
                                    <span class="text-xl">
                                        <i class="fa-solid {{ $resource->icon ? $resource->icon : 'fa-circle' }}"></i>
                                    </span>
                                    <span>{{ !empty($resource->plural) ? $resource->plural : $resource->name }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach

                   <li id="menu-item-current-user" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{ route('user.show') }}">
                            <div class="menu-item">
                                <span class="text-xl">
                                    <i class="fa-solid fa-user-circle"></i>
                                </span>
                                <span>Profile</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{ route('user.logout') }}">
                            <div class="menu-item">
                                <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="menu-item-text">Logout</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
</div>
*/ ?>
