<div class="dropdown">
    <div class="dropdown-toggle" id="user-dropdown" data-bs-toggle="dropdown">
        <div class="header-action-item flex items-center gap-2">
            <span class="avatar avatar-circle" data-avatar-size="32" style="width: 32px">
                <img class="avatar-img avatar-circle"
                     src="{{asset('backend/assets/img/avatars/thumb-1.jpg')}}"
                     loading="lazy" alt="">
            </span>
            <div class="hidden md:block">
                <div class="font-bold"> {{ Auth::guard('web')->user()->email }}</div>
            </div>
        </div>
    </div>

    <ul class="dropdown-menu bottom-end min-w-[240px]">
        <li class="menu-item-header">
            <div class="py-2 px-3 flex items-center gap-2">
                <span class="avatar avatar-circle avatar-md">
                    <img class="avatar-img avatar-circle"
                         src="{{asset('backend/assets/img/avatars/thumb-1.jpg')}}"
                         loading="lazy" alt="">
                </span>
                <div>
                    <div class="font-bold text-gray-900 dark:text-gray-100"> {{ Auth::guard('web')->user()->usernames }} </div>
                    <div class="text-xs"> {{ Auth::guard('web')->user()->email }} </div>
                </div>
            </div>
        </li>
        <li class="menu-item-divider"></li>
        <li class="menu-item menu-item-hoverable mb-1 h-[35px]">
            <a class="flex gap-2 items-center" href="#">
                <span class="text-xl opacity-50">
                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </span>
                <span>Profile</span>
            </a>
        </li>
        <li id="menu-item-29-2VewETdxAb" class="menu-item-divider"></li>
        <li class="menu-item menu-item-hoverable gap-2 h-[35px]">
            <a class="flex gap-2 items-center" href="{{route('logout')}}">
                <span class="text-xl opacity-50">
                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </span>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
