@php
    use App\Models\Portfolio\Job;
    use App\Models\System\Admin;

    $owner_id = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        @if(isRootAdmin())

                            @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])

                        @endif

                        @if(!empty($owner))

                            @php
                                $jobs = new Job()->listOptions(!empty($owner) ? [ 'owner_id' => $owner->id ] : [], 'id', 'company', true, false, [ 'company', 'asc' ]);
                                $jobId = Request::get('job_id');
                                if (!array_key_exists($jobId, $jobs)) {
                                    $jobId = null;
                                }
                            @endphp

                                <?php /* @TODO: Need to handle deselect of other fields when a new select list option is chosen. */ ?>
                            @if(count($jobs) > 1)
                                <div class="control">
                                    @include('guest.components.form-select', [
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
                    @include('guest.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('guest.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
