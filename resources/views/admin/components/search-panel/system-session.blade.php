@php
    use App\Enums\EnvTypes;
    use App\Models\System\Session;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $admin_id = $admin_id ?? request()->query('admin_id');
    $favorites      = $favorites ?? request()->query('favorites');
    $user_id  = $user_id ?? request()->query('user_id');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Session::SEARCH_ORDER_BY[0], Session::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Session()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="search-panel-body floating-div-container">

                    <div class="floating-div">
                        @include('admin.components.search-panel.controls.system-admin', [ 'admin_id' => $admin_id ])
                    </div>

                    <div class="floating-div">
                        @include('admin.components.search-panel.controls.system-user', [ 'user_id' => $user_id ])
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
