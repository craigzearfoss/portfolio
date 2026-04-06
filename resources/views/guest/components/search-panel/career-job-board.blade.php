@php
    use App\Models\Career\JobBoard;

    // get variables
    $action        = $action ?? url()->current();
    $name          = $name ?? request()->query('name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ JobBoard::SEARCH_ORDER_BY[0], JobBoard::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div pl-4">
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-job-board-coverage_area')
                        </div>
                    </div>

                </div>

                <div class="has-text-right pr-2">
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

            </div>

        </form>

    </div>

</div>
