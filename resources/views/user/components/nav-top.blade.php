@php
    use App\Enums\EnvTypes;

    $admin = $admin ?? null;
    $user  = $user ?? null;
    $owner = $owner ?? null;
@endphp
@if($menuItems = $menuService->topMenu())

    <nav id="navbar-main" class="navbar user is-fixed-top">
        <div class="navbar-brand">

            <a class="hamburger-icon" href="javascript:void(0);" onclick="toggleHamburgerMenu()">
                <i class="fa fa-bars m-2"></i>
            </a>

            <div class="navbar-item has-control">

                <span class="mr-4 has-text-dark" style=" font-size: 1.5em; font-weight: 800;">
                    @if(!empty($envType) && $envType === EnvTypes::USER)
                        @include('user.components.link', [
                            'name'  => config('app.name'),
                            'href'  => route('admin.index'),
                            'class' => 'header-page-title admin',
                        ])
                    @else
                        {{ config('app.name') }} Admin Area
                    @endif
                    {{ config('app.name') }}
                </span>

                @if(isDemo())
                    <span class="ml-4 p-2 pr-4 pl-4 has-background-info has-text-white-bis" style="font-weight: 700;">
                        Demo Mode
                    </span>
                @elseif(config('app.readonly'))
                    <span class="ml-4 p-2 pr-4 pl-4 has-background-info has-text-white-bis" style="font-weight: 700;">
                        Site is Read-only
                    </span>
                @endif

            </div>
        </div>
        <div class="navbar-brand is-right">

            @include('user.components.nav-link-top', [
                'name'       => false,
                'href'       => false,
                'class'      => 'is-hidden-desktop jb-navbar-menu-toggle',
                //'icon'       => '<span class="icon"><i class="mdi mdi-dots-vertical"></i></span>',
                'dataTarget' => 'navbar-menu'
            ])

        </div>

        @if (!in_array(Route::currentRouteName(), ['user.login', 'user.login-submit']))

            <div class="navbar-menu fadeIn animated faster" id="navbar-menu">
                <div class="navbar-end">

                    @foreach($menuItems as $menuItem)

                        <?php /* user dropdown menu at the top right */ ?>
                        @if($menuItem->name == 'user-dropdown')

                            <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider has-user-avatar is-hoverable">

                                @php
                                    $avatarElems = [];
                                    if (!empty($menuItem->thumbnail)) {
                                        $avatarElems[] = '<div class="is-user-avatar"><img src="'.$menuItem->thumbnail.'" alt="'.$menuItem->title.'"></div>';
                                    }
                                    $avatarElems[] = '<div class="is-user-name"><span>'.$menuItem->title.'</span></div>';
                                    if (!empty($menuItem->icon)) {
                                        $avatarElems[] = '<span class="text-xl"><i class="fa '.$menuItem->icon.'"></i>';
                                    }
                                @endphp

                                @include('user.components.nav-link-top', [
                                    'name'       => implode('', $avatarElems),
                                    'href'       => false,
                                    'class'      => 'navbar-link is-arrowless',
                                    'icon'       => false
                                ])

                                @if (!empty($menuItem->children))
                                    <div class="navbar-dropdown">

                                        @foreach($menuItem->children as $menuSubItem)
                                            @include('user.components.nav-link-top', [
                                                'name'   => (!empty($menuSubItem->plural) ? $menuSubItem->plural : $menuSubItem->title),
                                                'href'   => !empty($menuSubItem->url) ? $menuSubItem->url : false,
                                                'active' => $menuSubItem->active,
                                                'icon'   => !empty($menuSubItem->icon) ? $menuSubItem->icon : 'fa-circle'
                                            ])
                                        @endforeach

                                    </div>
                                @endif

                            </div>

                        @else

                            @php
                                $hideClass = match ($menuItem->tag) {
                                    'dictionary_db'               => 'hide-at-1400',
                                    'user_login', 'admin_login'   => 'hide-at-1300',
                                    'personal_db', 'portfolio_db' => 'hide-at-1200',
                                    default => '',
                                };
                            @endphp

                            <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider is-hoverable {{ $hideClass }}">

                                @include('user.components.nav-link-top', [
                                    'name'   => $menuItem->title,
                                    'href'   => $menuItem->url ?? false,
                                    'class'  => 'navbar-link is-arrowless',
                                    'icon'   => false
                                ])

                                @if(!empty($menuItem->children))

                                    <div class="navbar-dropdown">

                                        @foreach($menuItem->children as $menuSubItem)
                                            @include('user.components.nav-link-top', [
                                                'name'   => !empty($menuSubItem->plural) ? $menuSubItem->plural : $menuSubItem->title,
                                                'href'   => !empty($menuSubItem->url) ? $menuSubItem->url : false,
                                                'active' => $menuSubItem->active,
                                                'icon'   => !empty($menuSubItem->icon) ? $menuSubItem->icon : 'fa-circle'
                                            ])
                                        @endforeach

                                   </div>

                                @endif

                            </div>

                        @endif

                    @endforeach

                    <div class="right-home-admin-button-container aside-tools-label has-text-left ml-2 mr-2 mt-3 show-at-1024" style="width: auto; float: right;">

                        @include('guest.components.button-home', [
                            'name'     => 'Home',
                            'href'     => route('guest.index'),
                            'selected' => true,
                        ])

                        <span style="display: inline-block; background-color: red; width: 2px;"></span>

                        @include('guest.components.button-home', [
                            'name'     => 'Admin',
                            'href'     => route('admin.dashboard'),
                            'selected' => false,
                           'style'    => 'background: #2e323a;'
                        ])

                    </div>

                </div>

            </div>

        @endif

    </nav>

@endif
