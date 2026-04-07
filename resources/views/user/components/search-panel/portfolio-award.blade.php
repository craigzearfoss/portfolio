@php
    use App\Models\Portfolio\Award;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
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

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => [
                                       'category|asc'       => 'category',
                                       'name|asc'           => 'name',
                                       'nominated_work|asc' => 'nominated work',
                                       'organization|asc'   => 'organization',
                                       'year|asc'           => 'year',
                                   ],
				        'style' => [ 'width: 9rem !important', 'max-width: 9rem !important' ]
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('user.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('user.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'category',
                                'value'   => $category,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'nominated_work',
                                'label'   => 'nominated work',
                                'value'   => $nominated_work,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'organization',
                                'value'   => $organization,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
