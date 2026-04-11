@php
    use App\Models\Portfolio\Award;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $category        = $category ?? request()->query('category');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $name            = $name ?? request()->query('name');
    $nominated_work  = $nominated_work ?? request()->query('nominated_work');
    $organization    = $organization ?? request()->query('organization');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Award::SEARCH_ORDER_BY[0], Award::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => array_merge($isRootAdmin ? [ 'owner.username|asc' => 'owner' ] : [],
                                               [
                                                   'category|asc'       => 'category',
                                                   'created_at|desc'    => 'created at',
                                                   'name|asc'           => 'name',
                                                   'nominated_work|asc' => 'nominated_work',
                                                   'organization|asc'   => 'organization',
                                                   'updated_at|desc'    => 'updated at',
                                                   'year|asc'           => 'year',
                                               ],
                                   ),
				        'style' => [ 'width: 9rem !important', 'max-width: 9rem !important' ]
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

                    @if($isRootAdmin)
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
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'category',
                                'value'   => $category,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'nominated_work',
                                'label'   => 'nominated work',
                                'value'   => $nominated_work,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'organization',
                                'value'   => $organization,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                    @if($isRootAdmin)
                        <div class="floating-div">
                            @include('admin.components.search-panel.controls.timestamp-created-at', [
                                'created_at_from' => $created_at_from,
                                'created_at_to'   => $created_at_to,
                            ])
                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
