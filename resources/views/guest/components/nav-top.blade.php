@php
    use App\Enums\EnvTypes;

    $admin = $admin ?? null;
    $user  = $user ?? null;
    $owner = $owner ?? null;
@endphp
@if($menuItems = $menuService->topMenu())

    <nav id="navbar-main" class="navbar guest is-fixed-top">
        <div class="navbar-brand">

            <a class="hamburger-icon" href="javascript:void(0);" onclick="toggleHamburgerMenu()">
                <i class="fa fa-bars m-2"></i>
            </a>

            <div class="navbar-item has-control">

                <span class="mr-4 has-text-dark">
                    @if(!empty($envType) && $envType === EnvTypes::GUEST)
                        @include('guest.components.link', [
                            'name'  => config('app.name'),
                            'href'  => route('guest.index'),
                            'class' => 'header-page-title guest',
                        ])
                    @else
                        {{ config('app.name') }}
                    @endif
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

            @include('guest.components.nav-link-top', [
                'name'       => false,
                'href'       => false,
                'class'      => 'is-hidden-desktop jb-navbar-menu-toggle',
                //'icon'       => '<span class="icon"><i class="mdi mdi-dots-vertical"></i></span>',
                'dataTarget' => 'navbar-menu'
            ])

        </div>

        <div class="navbar-menu fadeIn animated faster" id="navbar-menu">
            <div class="navbar-end">

                @foreach($menuItems as $menuItem)

                    @if((get_class($menuItem) === 'stdClass') && ($menuItem->name === 'Resume'))

                        <div class="navbar-item has-dropdown has-dropdown-with-icons has-divider is-hoverable"
                             style="background-color: rgb(0, 158, 134) !important; color: #ffffff;"
                        >

                            <a href="{{ $menuItem->url }}"
                               class="navbar-link is-secondary is-arrowless navbar-item"
                               style="background-color: rgb(0, 158, 134)  !important; color: #ffffff;"
                            >
                                {{ $menuItem->title }}
                            </a>
                        </div>

                    @elseif($menuItem->name == 'user-dropdown')
                        <?php /* user dropdown menu at the top right */ ?>

                        <div
                            class="navbar-item has-dropdown has-dropdown-with-icons has-divider has-user-avatar is-hoverable"
                        >

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

                            @include('guest.components.nav-link-top', [
                                'name'       => implode('', $avatarElems),
                                'href'       => false,
                                'class'      => 'navbar-link is-arrowless',
                                'icon'       => false
                            ])

                            @if (!empty($menuItem->children))
                                <div class="navbar-dropdown">

                                    @foreach($menuItem->children as $menuSubItem)
                                        @include('guest.components.nav-link-top', [
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

                        <div
                            class="navbar-item has-dropdown has-dropdown-with-icons has-divider is-hoverable {{ $hideClass }}"
                        >

                            @include('guest.components.nav-link-top', [
                                'name'   => $menuItem->title,
                                'href'   => $menuItem->url ?? false,
                                'class'  => 'navbar-link is-arrowless',
                                'icon'   => false
                            ])

                            @if(!empty($menuItem->children))

                                <div class="navbar-dropdown">

                                    @foreach($menuItem->children as $menuSubItem)
                                        @include('guest.components.nav-link-top', [
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

            </div>

        </div>

        <div class="navbar-item nav-right-home-admin-container show-at-1024">

            @include('guest.components.button-home', [
                'name'     => 'Home',
                'href'     => route('guest.index'),
                'selected' => true,
            ])

            <span style="display: inline-block; width: 2px;"></span>

            @include('guest.components.button-home', [
                'name'     => 'Admin',
                'href'     => route('admin.dashboard'),
                'selected' => false,
                'style'    => 'background: #2e323a;'
            ])

        </div>

    </nav>

@endif
