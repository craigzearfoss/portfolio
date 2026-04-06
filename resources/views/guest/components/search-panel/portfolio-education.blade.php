@php
    use App\Models\Portfolio\Education;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $major           = $major ?? request()->query('major');
    $minor           = $minor ?? request()->query('minor');
    $school_name     = $school_name ?? request()->query('school_name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Education::SEARCH_ORDER_BY[0], Education::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => [
                                       'degree_type_name|asc'  => 'degree',
                                       'major|asc'             => 'major',
                                       'minor|asc'             => 'minor',
                                       'school_name|asc'       => 'school',
                                       'enrollment_date|desc'  => 'year enrolled',
                                       'graduation_date|desc'  => 'year graduated',
                                   ],
                        'style' => [ 'width: 9rem', 'max-width: 9rem' ]
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

                <div class="floating-div-container">

                    <div class="floating-div">

                        <?php /*
                        // @TODO: too many schools for a select list
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-school')
                        </div>
                        */ ?>

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'school_name',
                                'label'   => 'school',
                                'value'   => $school_name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-education-degree-type', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'major',
                                'value'   => $major,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'minor',
                                'value'   => $minor,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
