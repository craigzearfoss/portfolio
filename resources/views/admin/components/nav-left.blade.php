@php
$menuItems = (new \App\Services\MenuService())->getLeftMenu(
    \App\Services\PermissionService::ENV_ADMIN,
    $admin ?? null
);
@endphp

<aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
    <div class="aside-tools">
        <div class="aside-tools-label">

            @if(isAdmin())

                @include('admin.components.link', [
                    'name'  => 'Home',
                    'href'  => route('system.index'),
                    'class' => 'has-text-primary',
                    'style' => 'font-size: 1.2em; font-weight: 700',
                ])

                /

                @include('admin.components.link', [
                    'name'  => 'Admin',
                    'href'  => route('admin.index'),
                    'class' => 'has-text-primary',
                    'style' => 'font-size: 1.2em; font-weight: 700',
                ])

            @else

                @include('admin.components.link', [
                    'name'  => 'Home',
                    'href'  => route('system.index'),
                    'class' => 'has-text-primary',
                    'style' => 'font-size: 1.2em; font-weight: 700',
                ])

            @endif

        </div>
    </div>

    @foreach ($menuItems as $menuItem)

        <ul class="menu is-menu-main">

            <p class="menu-label pb-0 mb-0">
                <a @if (!empty($menuItem->link))href="{{ $menuItem->link }}" @endif
                   class="has-text-white {{ $menuItem->active ? 'is-active' : '' }}"
                >
                    {{ $menuItem->title }}
                </a>
            </p>

            @if(!empty($menuItem->children))

                <ul class="menu-list pl-2">

                    @foreach ($menuItem->children as $menuSubItem)
                        <li>
                            <a @if (!empty($menuSubItem->link))href="{{ $menuSubItem->link }}"  @endif
                                class="{{ $menuSubItem->active ? 'is-active' : '' }}"
                            >
                                <div class="menu-item">
                                    <span class="text-xl">
                                        <i class="fa-solid {{ !empty($menuSubItem->icon) ? $menuSubItem->icon : 'fa-circle' }}"></i>
                                    </span>
                                    <span class="menu-item-label">
                                        {{ !empty($menuSubItem->plural) ? $menuSubItem->plural : $menuSubItem->title }}
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endforeach

                </ul>

            @endif

        </ul>
    @endforeach

</aside>
