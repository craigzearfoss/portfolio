@php
    use App\Models\Portfolio\Certificate;
    use App\Models\System\Admin;

    // get variables
    $action       = $action ?? url()->current();
    $owner_id     = $owner->id ?? -1;
    $academy_id   = $academy_id ?? request()->query('academy_id');
    $name         = $name ?? request()->query('name');
    $organization = $organization ?? request()->query('organization');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Certificate::SEARCH_ORDER_BY[0], Certificate::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => [
                                      'academy_name|asc' => 'academy',
                                      'expiration|asc'   => 'expiration',
                                      'name|asc'         => 'name',
                                      'received|asc'     => 'received',
                                      'year|asc'         => 'year',
                                  ],
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
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-academy', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
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
