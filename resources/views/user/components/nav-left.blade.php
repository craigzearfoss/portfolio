@php
    use App\Models\System\Owner;

    $admin = $admin ?? null;
    $user  = $user ?? null;
    $owner = $owner ?? null;

    $menItems       = [];
    $adminItems     = [];
    $candidateItems = [];
    $resourceItems  = [];

    if ($menuService ?? null) {
        $menuItems = $menuService->leftMenu();
    }
//dd($menuItems);
/*
//dd($menuItems);
    if (empty($owner)) {
        $adminItems = $menuItems;
    } else {
        foreach ($menuItems as $menuItem) {
            if (
                (property_exists($menuItem, 'owner_id') && ($menuItem->owner_id == $owner->id))
                || (property_exists($menuItem, 'table') && in_array($menuItem->tag, [ 'personal_db', 'portfolio_db' ]))
            ) {
                $candidateItems[] = $menuItem;
            } else {//dd($menuItem, property_exists($menuItem, 'table'), in_array($menuItem->tag, [ 'personal_db', 'portfolio_db' ]));
                $adminItems[] =$menuItem;
            }
        }
    }
*/
//dd($menuItems);
@endphp

<aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
    <div class="aside-tools">
        <div class="aside-tools-label has-text-left has-text-centered" style="width: 100%;">

            @include('user.components.button-home', [
                'name'     => 'Home',
                'href'     => route('user.index'),
                'selected' => true,
            ])

            @if (Auth::guard('admin')->check() || !config('app.single_admin_mode'))
                <span class="home-admin-button-separator"></span>
                @include('user.components.button-home', [
                    'name'     => 'Admin',
                    'href'     => route('admin.dashboard'),
                    'selected' => false,
                ])
            @endif

        </div>
    </div>

    @include('user.components.nav-left-candidate-card', [
        'candidateItems' => $menuItems['candidate'],
        'owner'          => $owner,
    ])

    @include('user.components.nav-left-resources-card', [
        'resourceItems' => $menuItems['resources'] ?? [],
        'owner'         => $owner,
    ])

    @include('user.components.nav-left-tools-card', [
        'toolItems' => $menuItems['tools'] ?? [],
        'owner'     => $owner,
    ])

    @include('user.components.nav-left-dictionary-card', [
        'dictionaryItems' => $menuItems['dictionary'] ?? [],
        'owner'           => $owner,
    ])

    @include('user.components.nav-left-system-items', [
        'systemItems' => $menuItems['system'],
        'owner'       => $owner,
    ])

</aside>

