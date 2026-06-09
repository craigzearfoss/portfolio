@php
    use App\Models\System\Owner;

    $admin = $admin ?? null;
    $user  = $user ?? null;
    $owner = $owner ?? null;

    $menItems       = [];
    $adminItems     = [];
    $candidateItems = [];
    $resourceItems  = [];

    $menuItems = !empty( $menuService) ? $menuService->leftMenu() : [];
@endphp

<aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
    <div class="aside-tools">
        <div class="aside-tools-label has-text-left has-text-centered" style="width: 100%;">

            @include('guest.components.button-home', [
                'name'     => 'Home',
                'href'     => route('guest.index'),
                'selected' => true,
            ])

            @if (Auth::guard('admin')->check() || !config('app.single_admin_mode'))
                <span class="home-admin-button-separator"></span>
                @include('guest.components.button-home', [
                    'name'     => 'Admin',
                    'href'     => route('admin.dashboard'),
                    'selected' => false,
                ])
            @endif

        </div>
    </div>

    @include('guest.components.nav-left-candidate-card', [
        'candidateItems' => $menuItems['candidate'],
        'owner'          => $owner,
    ])

    @include('guest.components.nav-left-resources-card', [
        'resourceItems' => $menuItems['resources'] ?? [],
        'owner'         => $owner,
    ])

    @include('guest.components.nav-left-tools-card', [
        'toolItems' => $menuItems['tools'] ?? [],
        'owner'     => $owner,
    ])

    @include('guest.components.nav-left-dictionary-card', [
        'dictionaryItems' => $menuItems['dictionary'] ?? [],
        'owner'           => $owner,
    ])

    @include('guest.components.nav-left-system-items', [
        'systemItems' => $menuItems['system'],
        'owner'       => $owner,
    ])

</aside>

