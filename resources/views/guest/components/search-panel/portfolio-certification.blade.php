@php
    use App\Models\Portfolio\Certification;
    use App\Models\Career\JobBoard;

    // get variables
    $action          = $action ?? url()->current();
    $abbreviation    = $abbreviation ?? request()->query('abbreviation');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $name            = $name ?? request()->query('name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Certification::SEARCH_ORDER_BY[0], Certification::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => [
                                       'abbreviation|asc' => 'abbreviation',
                                       'name|asc'         => 'name',
                                       'type_name|asc'    => 'type',
                                   ],
                        'style' => [ 'width: 8rem important!', 'min-width: 8rem !important' ]
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
                            @include('guest.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div pl-4">

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'abbreviation',
                                'value'   => $abbreviation,
                                'message' => $message ?? '',
                                'style'   => 'width: 6rem;',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-certification-certification_type')
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
