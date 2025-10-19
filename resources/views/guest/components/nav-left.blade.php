@php
$menuItems = (new \App\Services\MenuService())->getLeftMenu(
    \App\Services\PermissionService::ENV_GUEST,
     $admin ?? null
 );
@endphp

<aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
    <div class="aside-tools">
        <div class="aside-tools-label">


            @if(!empty($admin))

                @include('admin.components.link', [
                    'name'  => $admin->name,
                    'href'  => route('guest.user.index', $admin),
                    'style' => 'font-size: 1.2em; font-weight: 700',
                ])

                <?php /*
                @include('admin.components.form-select-nolabel', [
                    'value'    => $admin->username ?? '',
                    'list'     => \App\Models\System\Admin::listOptions([
                                            'public' => 1,
                                        ],
                                        'username',
                                        'name',
                                        \App\Models\System\Admin::where('public', 1)->count() > 1,
                                        false,
                                        ['name', 'asc'
                                    ]),
                    'style'    => 'font-size: 1.2em; font-weight: 700',
                    'onchange' => "document.location.href='/'+this.value;"
                ])
                */ ?>

            @else

                <a class="has-text-primary" href="{{ route('guest.homepage') }}"><strong>{{ config('app.name') }}</strong></a>

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
