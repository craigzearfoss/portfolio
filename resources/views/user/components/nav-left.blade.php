@php
$menuItems = (new \App\Services\MenuService())->getLeftMenu(
    \App\Services\PermissionService::ENV_USER,
    $admin ?? null
);
@endphp

<aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
    <div class="aside-tools">
        <div class="aside-tools-label">

            <a class="has-text-primary" href="{{ route('system.index') }}"><strong>{{ config('app.name') }}</strong></a>

        </div>
    </div>

    @foreach ($menuItems as $menuItem)

        <ul class="menu is-menu-main" style="font-size: 1rem;">

            <p class="menu-label pb-0 mb-0">
                <a @if (!empty($menuItem->link))href="{{ $menuItem->link }}" @endif
                   class="has-text-white {{ $menuItem->active ? 'is-active' : '' }}"
                   style="padding: 0.3rem;"
                >
                    {{ $menuItem->title }}
                </a>
            </p>

            @if(!empty($menuItem->children))

                <ul class="menu-list pl-2" style="{{ $menuItem->children[0]->level == 2 ? 'margin-left: 1rem;' : ''}}">

                    @foreach ($menuItem->children as $menuSubItem)
                        <li @if(($menuItem->name == 'portfolio') && in_array($menuSubItem->name, ['job'])) style="display: none !important" @endif>
                            <a @if (!empty($menuSubItem->link))href="{{ $menuSubItem->link }}"  @endif
                                class="{{ $menuSubItem->active ? 'is-active' : '' }}"
                               style="padding: 0.3rem;"
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
