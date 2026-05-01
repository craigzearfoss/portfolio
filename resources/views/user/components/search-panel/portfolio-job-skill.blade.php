@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\JobSkill;
    use App\Models\System\Admin;

    // get variables
    $action         = $action ?? url()->current();
    $company_name   = $company_name ?? request()->query('company_name');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $job_id         = $job_id ?? request()->query('job_id');
    $name           = $name ?? request()->query('name');
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $role           = $role ?? request()->query('role');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ JobSkill::SEARCH_ORDER_BY[0], JobSkill::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new JobSkill()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
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

                        @if ($isRootAdmin)
                            <div class="search-form-control">
                                @include('user.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])

                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.portfolio-job', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'company_name',
                                'label'   => 'company',
                                'value'   => $company_name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'role',
                                'value'   => $role,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>

                    @if ($isRootAdmin)
                        <div class="floating-div">

                            @include('user.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('user.components.search-panel.controls.timestamp-updated-at', [
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
