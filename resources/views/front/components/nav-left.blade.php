@php
$menuItems = (new \App\Services\MenuService())->getLeftMenu();
@endphp

<aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
    <div class="aside-tools">
        <div class="aside-tools-label">

            @if (Auth::guard('admin'))
                <a href="{{ route('admin.dashboard') }}">{{ config('app.name') }} Admin</a>
            @else
                <a href="{{ route('admin.index') }}">{{ config('app.name') }} Admin</a>
            @endif

        </div>
    </div>

    @foreach ($menuItems as $menuItem)

        <ul class="menu is-menu-main">

            <p class="menu-label pb-0 mb-0">
                @if (!empty($menuItem->link))
                    <a href="{{ $menuItem->link }}" class="has-text-white {{ $menuItem->active ? 'id-active' : '' }}">
                        {{ $menuItem->title }}
                    </a>
                @else
                    <a class="has-text-white {{ $menuItem->active ? 'id-active' : '' }}">
                        {{ $menuItem->title }}
                    </a>
                @endif
            </p>

            <ul class="menu-list pl-2">
                @foreach ($menuItem->children as $menuSubItem)
                    <li>
                        @if (!empty($menuSubItem->link))
                            <a href="{{ $menuSubItem->link }}" class="{{ $menuSubItem->active ? 'is-active' : '' }}">
                                <div class="menu-item">
                                    <span class="text-xl">
                                        <i class="fa-solid {{ !empty($menuSubItem->icon) ? $menuSubItem->icon : 'fa-circle' }}"></i>
                                    </span>
                                    <span class="menu-item-label">
                                        {{ $menuSubItem->title }}
                                    </span>
                                </div>
                            </a>
                        @else
                            <a class="{{ $menuSubItem->active ? 'is-active' : '' }}">
                                <div class="menu-item">
                                    <span class="text-xl">
                                        <i class="fa-solid {{ !empty($menuSubItem->icon) ? $menuSubItem->icon : 'fa-circle' }}"></i>
                                    </span>
                                    <span class="menu-item-label">
                                        {{ $menuSubItem->title }}
                                    </span>
                                </div>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>

        </ul>
    @endforeach

</aside>
