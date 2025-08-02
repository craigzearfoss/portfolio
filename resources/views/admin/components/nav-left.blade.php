<div class="side-nav side-nav-transparent side-nav-expand">
    <div class="side-nav-header">
        <div class="logo px-6">

            @if (Auth::guard('admin'))
                <a href="{{route('admin.dashboard')}}">
                    <h4 style="margin: 10px 0; color: #222;">{{ config('app.name') }}</h4>
                </a>
            @else
                <a href="{{route('admin.index')}}">
                    <h4 style="margin: 10px 0; color: #222;">{{ config('app.name') }}</h4>
                </a>
            @endif
        </div>

    </div>
    <div class="side-nav-content relative side-nav-scroll">
        <nav class="menu menu-transparent px-4 pb-4">

            <div class="menu-group">
                <ul>
                    <li id="menu-item-29-2VewETdxAb" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.link.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-link"></i>
                                </span>
                                <span>Links</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.project.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-wrench"></i>
                                </span>
                                <span>Projects</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.reading.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-book"></i>
                                </span>
                                <span>Readings</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.video.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-video-camera"></i>
                                </span>
                                <span>Videos</span>
                            </div>
                        </a>
                    </li>

                    <li id="menu-item-29-2VewETdxAb" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.application.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-chevron-circle-right"></i>
                                </span>
                                <span>Applications</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.certificate.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-certificate"></i>
                                </span>
                                <span>Certificates</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.communication.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-phone"></i>
                                </span>
                                <span>Communications</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.company.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-industry"></i>
                                </span>
                                <span>Companies</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.contact.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-address-book"></i>
                                </span>
                                <span>Contacts</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.cover-letter.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-file-text"></i>
                                </span>
                                <span>Cover Letters</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.note.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-sticky-note"></i>
                                </span>
                                <span>Notes</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.resume.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-file"></i>
                                </span>
                                <span>Resumes</span>
                            </div>
                        </a>
                    </li>

                    <li id="menu-item-29-2VewETdxAb" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.admin.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-user-plus"></i>
                                </span>
                                <span>Admins</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.user.index')}}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <span>Users</span>
                            </div>
                        </a>
                    </li>
                   <li id="menu-item-29-2VewETdxAb" class="menu-item-divider"></li>
                    <li class="menu-collapse">
                        <a href="{{ route('admin.profile') }}">
                            <div class="menu-item">
                                <span class="text-xl opacity-50">
                                    <i class="fa-solid fa-user-circle"></i>
                                </span>
                                <span>Profile</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu-collapse">
                        <a href="{{route('admin.logout')}}">
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
