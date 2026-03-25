@php
    use App\Models\System\Admin;

    $owner_id          = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $admin_database_id = $admin_database_id ?? request()->query('admin_database_id');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            @include('user.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])

            @include('user.components.search-panel.controls.system-admin-database', [ 'admin_database_id' => $admin_database_id ])

        </form>

    </div>

</div>
