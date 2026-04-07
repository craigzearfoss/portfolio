@php
    use App\Models\Portfolio\Job;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Job::SEARCH_ORDER_BY[0], Job::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        @if(!empty($owner))

                            @php
                                $jobs = new Job()->listOptions(
                                    [ 'owner_id' => $owner->id ],
                                    'id',
                                    'company',
                                    true,
                                    false,
                                    [ 'company', 'asc' ]
                                );

                                $jobId = Request::get('job_id');
                                if (!array_key_exists($jobId, $jobs)) {
                                    $jobId = null;
                                }
                            @endphp

                            <?php /* @TODO: Need to handle deselect of other fields when a new select list option is chosen. */ ?>
                            @if(count($jobs) > 1)
                                <div class="control">
                                    @include('user.components.form-select', [
                                        'name'     => 'job_id',
                                        'label'    => 'job',
                                        'value'    => $jobId,
                                        'list'     => $jobs,
                                    ])
                                </div>
                            @endif
                        @endif

                    </div>

                </div>

                <div class="has-text-right pr-2">
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

            </div>

        </form>

    </div>

</div>
