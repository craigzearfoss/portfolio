@php
    use App\Models\Dictionary\Category;
    use App\Models\Portfolio\Skill;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $name            = $name ?? request()->query('name');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $min_years       = $min_years ?? request()->query('min_years');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Skill::SEARCH_ORDER_BY[0], Skill::SEARCH_ORDER_BY[1] ]);
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
                                                   'created_at|desc'              => 'created at',
                                                   'dictionary_category_name|asc' => 'category',
                                                   'level|desc'                   => 'level',
                                                   'name|asc'                     => 'name',
                                                   'updated_at|desc'              => 'updated at',
                                                   'years|desc'                   => 'years',
                                               ],
                                   ),
                        'style' => [ 'width: 7rem !important', 'max-width: 7rem !important' ]
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
                            @include('admin.components.search-panel.controls.dictionary-category')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.portfolio-skill-level')
                        </div>

                    </div>

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'type'    => 'number',
                                'name'    => 'min_years',
                                'label'    => 'min years',
                                'value'   => $min_years,
                                'min'     => 1,
                                'max'     => 30,
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
