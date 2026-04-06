@php
    use App\Models\Portfolio\JobSkill;
    use App\Models\System\Admin;

    // get variables
    $action       = $action ?? url()->current();
    $owner_id     = $owner->id ?? -1;
    $company_name = $company_name ?? request()->query('company_name');
    $job_id       = $job_id ?? request()->query('job_id');
    $name         = $name ?? request()->query('name');
    $role         = $role ?? request()->query('role');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ JobSkill::SEARCH_ORDER_BY[0], JobSkill::SEARCH_ORDER_BY[1] ]);
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
                                      'name|asc'         => 'name',
                                      'role|asc'         => 'role',
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

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-job', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'company',
                                'value'   => $company,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'role',
                                'value'   => $role,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
