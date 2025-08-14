<div class="side-nav side-nav-transparent side-nav-expand">
    <div class="side-nav-header">
        <div class="logo px-6">

            @if (Auth::guard('admin'))
                <a href="{{ route('admin.dashboard') }}">
                    <h4 style="margin: 10px 0; color: #222;">{{ config('app.name') }} Admin</h4>
                </a>
            @else
                <a href="{{ route('admin.index') }}">
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
                            <a @if (strpos(Route::currentRouteName(), 'admin.' . $resource->type) !== 0)
                                   href="{{ route('admin.' . $resource->type . '.index') }}"
                                @endif
                            >
                                <div class="menu-item {{ (strpos(Route::currentRouteName(), 'admin.' . $resource->type) === 0) ? 'menu-item-active' : '' }}">
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
                        <a href="{{ route('admin.show') }}">
                            <div class="menu-item">
                                <span class="text-xl">
                                    <i class="fa-solid fa-user-circle"></i>
                                </span>
                                <span>Profile</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{ route('admin.logout') }}">
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
