@php
    use App\Enums\EnvTypes;
    use App\Models\System\AdminDatabase;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $database       = $database ?? request()->query('database');
    $favorites      = $favorites ?? request()->query('favorites');
    $name           = $name ?? request()->query('name');
    $owner_id       = !empty($admin) && empty($admin->is_root)
        ? $admin->id
        : request()->query('owner_id');
    $search_title   = $search_title ?? request()->query('title');
    $tag            = $tag ?? request()->query('tag');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ AdminDatabase::SEARCH_ORDER_BY[0], AdminDatabase::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new AdminDatabase()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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

                <div class="floating-div-container">

                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'database',
                                'value'   => $database,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'tag',
                                'value'   => $tag,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'title',
                                'label'   => 'title',
                                'value'   => $search_title,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                    </div>

                    @if ($isRootAdmin)
                        <div class="floating-div">

                            @include('admin.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('admin.components.search-panel.controls.timestamp-updated-at', [
                                'updated_at-min' => $updated_at_min,
                                'updated_at-max' => $updated_at_max,
                            ])

                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
