@php
    use App\Models\Career\Resume;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $name            = $name ?? request()->query('name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Resume::SEARCH_ORDER_BY[0], Resume::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => [
                                       'name|asc'         => 'name',
                                       'resume_date|desc' => 'date',
                                   ],
                        'style' => [ 'width: 10rem', 'max-width: 10rem' ]
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
                            @include('user.components.input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.primary')
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.public')
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
