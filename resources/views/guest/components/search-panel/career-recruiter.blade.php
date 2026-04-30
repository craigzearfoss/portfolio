@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Recruiter;

    // get variables
    $action         = $action ?? url()->current();
    $city           = $city ?? request()->query('city');
    $name           = $name ?? request()->query('name');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Recruiter::SEARCH_ORDER_BY[0], Recruiter::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Recruiter()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 7rem !important', 'max-width: 7rem !important' ]
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

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-recruiter-coverage_area')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.system-state')
                        </div>

                    </div>

                    @if($isRootAdmin)
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

                </div>

            </div>

        </form>

    </div>

</div>
