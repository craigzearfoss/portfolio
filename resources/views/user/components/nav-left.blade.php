<div class="side-nav side-nav-transparent side-nav-expand">
    <div class="side-nav-header">
        <div class="logo px-6">

            {{-- Note: In the User->index() action we check if the user is logged in, but include it here in case you want to change the routes. --}}
            @if (Auth::guard('web'))
                <a class="no-underline" href="{{ route('front.homepage') }}">
                    <h4 style="margin: 10px 0; color: #222;">{{ config('app.name') }}</h4>
                </a>
            @else
                <a href="{{ route('front.homepage') }}">
                    <h4 style="margin: 10px 0; color: #222;">{{ config('app.name') }}</h4>
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
                    @foreach(\App\Models\Resource::where('disabled', 0)->where('public', 1)->get() as $i=>$resource)
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
                        <a href="{{ route('user.show') }}">
                            <div class="menu-item">
                                <span class="text-xl">
                                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
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
