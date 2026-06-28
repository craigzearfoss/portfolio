@php
    use App\Enums\EnvTypes;
    use App\Models\System\Database;
    use App\Models\System\Resource;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $database_id    = $database_id ?? request()->query('database_id');
    $database_tag   = $database_tag ?? request()->query('database_tag');
    $favorites      = $favorites ?? request()->query('favorites');
    $name           = $name ?? request()->query('name');
    $owner_id       = !empty($admin) && empty($admin->is_root)
        ? $admin->id
        : request()->query('owner_id');
    $table_name     = $table_name ?? request()->query('table_name');
    $search_title   = $search_title ?? request()->query('title');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Resource::SEARCH_ORDER_BY[0], Resource::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Resource()->getSortOptions($sort),
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('guest.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('guest.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="search-panel-body floating-div-container">

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif
                    */ ?>

                    <div class="floating-div">

                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
                                    'name'     => 'database_id',
                                    'label'    => 'database',
                                    'value'    => $database_id,
                                    'list'     => new Database()->listOptions(
                                                      [ 'owner_id' => 1 ],
                                                      'id',
                                                      'name',
                                                      true,
                                                      false,
                                                      [ 'name', 'asc' ]
                                                  ),
                                    'style'    => 'width: 12rem;'
                                ])
                            </div>
                        </div>

                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
                                    'name'     => 'database_tag',
                                    'label'    => 'db tag',
                                    'value'    => $database_tag,
                                    'list'     => new Database()->listOptions(
                                                      [ 'owner_id' => 1 ],
                                                      'tag',
                                                      'tag',
                                                      true,
                                                      false,
                                                      [ 'tag', 'asc' ]
                                                  ),
                                    'style'    => 'width: 12rem;'
                                ])
                            </div>
                        </div>

                    </div>
                    <div class="floating-div">

                        <?php /*
                        @if ($isRootAdmin)
                            <div class="search-form-control">
                                <div class="control" style="max-width: 28rem;">
                                    @include('guest.components.form-select', [
                                        'name'  => 'table_name',
                                        'label' => 'table',
                                        'value' => $table_name,
                                        'list'  => new Resource()->listOptions(
                                                       [ 'owner_id' => 1 ],
                                                       'table_name',
                                                       'table_name',
                                                       true,
                                                       false,
                                                       [ 'table_name', 'asc' ]
                                                   ),
                                        'style' => 'width: 12rem;'
                                    ])
                                </div>
                            </div>
                        @endif
                        */ ?>

                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
                                    'name'  => 'name',
                                    'value' => $name,
                                    'list'  => new Resource()->listOptions(
                                                   [ 'owner_id' => 1 ],
                                                   'name',
                                                   'name',
                                                   true,
                                                   false,
                                                   [ 'name', 'asc' ]
                                               ),
                                    'style' => 'width: 12rem;'
                                ])
                            </div>
                        </div>

                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
                                    'name'  => 'title',
                                    'value' => $search_title,
                                    'list'  => new Resource()->listOptions(
                                                   [ 'owner_id' => 1 ],
                                                   'title',
                                                   'title',
                                                   true,
                                                   false,
                                                   [ 'title', 'asc' ]
                                               ),
                                    'style' => 'width: 12rem;'
                                ])
                            </div>
                        </div>

                    </div>

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">

                            @include('guest.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('guest.components.search-panel.controls.timestamp-updated-at', [
                                'updated_at-min' => $updated_at_min,
                                'updated_at-max' => $updated_at_max,
                            ])

                        </div>
                    @endif
                    */ ?>

                </div>

            </div>

        </form>

    </div>

</div>
