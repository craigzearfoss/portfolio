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

                    <li id="menu-item-29-2VewETdxAb" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{route('project.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-wrench"></i>
                                </span>
                                <span>Projects</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('certificate.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-certificate"></i>
                                </span>
                                <span>Certificates</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('link.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-link"></i>
                                </span>
                                <span>Links</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('reading.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-book"></i>
                                </span>
                                <span>Readings</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('video.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-video-camera"></i>
                                </span>
                                <span>Videos</span>
                            </div>
                        </a>
                    </li>
                </ul>

                <div class="menu-title">Authentication</div>
                <ul>

                    <li id="menu-item-29-2VewETdxAb" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{route('login')}}">
                            <div class="menu-item">
                                <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="menu-item-text">Sign In</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('register')}}">
                            <div class="menu-item">
                                <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span class="menu-item-text">Sign Up</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('forgot_password')}}">
                            <div class="menu-item">
                                <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="menu-item-text">Forgot Password</span>
                            </div>
                        </a>
                    </li>
                    <?php /*
                    <li class="menu-collapse">
                        <a href="#">
                            <div class="menu-item">
                                <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                <span class="menu-item-text">Reset Password</span>
                            </div>
                        </a>
                    </li>
                    */ ?>

                </ul>
            </div>

        </nav>
    </div>
</div>
