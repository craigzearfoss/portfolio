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

                    <li id="menu-item-user-login" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{ route('user.login') }}">
                            <div class="menu-item">
                                <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="menu-item-text">Sign In</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{ route('user.register') }}">
                            <div class="menu-item">
                                <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span class="menu-item-text">Sign Up</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{ route('user.forgot_password') }}">
                            <div class="menu-item">
                                <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="menu-item-text">Forgot Password</span>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>

        </nav>
    </div>
</div>
