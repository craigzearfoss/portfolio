@php
$menuItems = (new \App\Services\MenuService())->getLeftMenu();
@endphp

<aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
    <div class="aside-tools">
        <div class="aside-tools-label">

            <a class="has-text-primary" href="{{ route('front.homepage') }}"><strong>{{ config('app.name') }}</strong></a>

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

        </ul>
    @endforeach

</aside>
