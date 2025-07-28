<div class="side-nav side-nav-transparent side-nav-expand">
    <div class="side-nav-header">
        <div class="logo px-6">
            <h4 style="margin: 10px 0; color: #222;">{{ config('app.name') }}</h4>
        </div>
    </div>
    <div class="side-nav-content relative side-nav-scroll">
        <nav class="menu menu-transparent px-4 pb-4">

            <div class="menu-group">
                <ul>
                    <li class="menu-collapse">
                        <a href="#">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </span>
                                <span>Profile</span>
                            </div>
                        </a>
                    </li>
                    <li id="menu-item-29-2VewETdxAb" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{route('logout')}}">
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
