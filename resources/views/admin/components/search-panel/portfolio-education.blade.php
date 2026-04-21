@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\Education;
    use App\Models\System\Admin;

    // get variables
    $action           = $action ?? url()->current();
    $owner_id         = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $created_at_from  = $created_at_from ?? request()->query('created_at_from');
    $created_at_to    = $created_at_to ?? request()->query('created_at_to');
    $enrollment_date  = $enrollment_date ?? request()->query('enrollment_date');
    $graduation_date  = $graduation_date ?? request()->query('graduation_date');
    $major            = $major ?? request()->query('major');
    $minor            = $minor ?? request()->query('minor');
    $school_name      = $school_name ?? request()->query('school_name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Education::SEARCH_ORDER_BY[0], Education::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Education()->getSearchOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div-container">

                    @if($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        <?php /*
                        // @TODO: too many schools for a select list
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.portfolio-school')
                        </div>
                        */ ?>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'school_name',
                                'label'   => 'school',
                                'value'   => $school_name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.portfolio-education-degree-type', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'major',
                                'value'   => $major,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'minor',
                                'value'   => $minor,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                    @if($isRootAdmin)
                        <div class="floating-div">
                            @include('admin.components.search-panel.controls.timestamp-created-at', [
                                'created_at_from' => $created_at_from,
                                'created_at_to'   => $created_at_to,
                            ])
                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
