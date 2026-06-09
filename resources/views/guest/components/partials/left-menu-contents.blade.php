@php
    use App\Models\System\Owner;

    $admin = $admin ?? null;
    $user  = $user ?? null;
    $owner = $owner ?? null;

    $menuItems = !empty($menuService) ? $menuService->leftMenu() : [];
@endphp

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

