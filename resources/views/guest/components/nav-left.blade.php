@php
$menuItems = (new \App\Services\MenuService())->getLeftMenu(
    \App\Services\PermissionService::ENV_GUEST,
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

    <div class="control ml-2 mt-2">

        @if(\App\Models\System\Admin::where('public', 1)->count() > 1)

            @include('admin.components.form-select-nolabel', [
                'value'    => !empty($admin->username) ? $admin->username : '',
                'list'     => \App\Models\System\Admin::listOptions([
                                        'public' => 1,
                                    ],
                                    'username',
                                    'name',
                                    true,
                                    false,
                                    ['name', 'asc'
                                ]),
                'style'    => 'font-size: 1.2em; font-weight: 700',
                'onchange' => "document.location.href='/'+this.value;"
            ])

        @endif

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
                        <li @if(($menuItem->name == 'portfolio') && in_array($menuSubItem->name, ['job'])) style="display: none !important" @endif>
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
