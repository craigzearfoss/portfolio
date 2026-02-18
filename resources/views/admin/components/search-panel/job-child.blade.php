<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">
        <form id="searchForm" action="{!! $action !!}" method="get">

            @if(isRootAdmin())

                <div class="control" style="max-width: 28rem;">
                    @include('admin.components.form-select', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => !empty($owner->root) ? null : ($owner->id ?? null),
                        'list'     => \App\Models\System\Admin::listOptions(
                            [],
                            'id',
                            'username',
                            true,
                            false,
                            [ 'username', 'asc' ]
                        ),
                        'onchange' => "document.getElementById('searchForm').submit()"
                    ])
                </div>

            @endif

            @if(!empty($owner))

                @php
                    $jobs = \App\Models\Portfolio\Job::listOptions(
                        !empty($owner) ? [ 'owner_id' => $owner->id ] : [],
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
                    @include('admin.components.form-select', [
                        'name'     => 'job_id',
                        'label'    => 'job',
                        'value'    => $jobId,
                        'list'     => $jobs,
                        'onchange' => "document.getElementById('searchForm').submit()"
                    ])
                </div>
                @endif
            @endif

        </form>

    </div>

</div>
