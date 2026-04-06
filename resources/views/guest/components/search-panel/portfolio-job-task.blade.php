@php
    use App\Models\Portfolio\JobTask;
    use App\Models\System\Admin;

    // get variables
    $action       = $action ?? url()->current();
    $owner_id     = $owner->id ?? -1;
    $company_name = $company_name ?? request()->query('company_name');
    $job_id       = $job_id ?? request()->query('job_id');
    $name         = $name ?? request()->query('name');
    $summary      = $summary ?? request()->query('summary');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ JobTask::SEARCH_ORDER_BY[0], JobTask::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => [
                                      'company_name|asc' => 'company',
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
                            @include('guest.components.search-panel.controls.portfolio-job', [ 'owner_id' => $owner_id ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'company_name',
                                'name'    => 'company',
                                'value'   => $company_name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'summary',
                                'value'   => $summary,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
