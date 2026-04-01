@php
    use App\Models\System\Admin;

    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $company         = $company ?? request()->query('company');
    $job_id          = $job_id ?? request()->query('job_id');
    $name            = $name ?? request()->query('name');
    $role            = $role ?? request()->query('role');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-job', [ 'owner_' => $owner_id ])
                        </div>
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'company',
                                'value'   => $company,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        @include('guest.components.search-panel.controls.timestamp-created-at', [
                            'created_at_from' => $created_at_from,
                            'created_at_to'   => $created_at_to,
                        ])
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
