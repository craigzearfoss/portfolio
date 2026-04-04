@php
    use App\Models\System\Admin;

    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
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
