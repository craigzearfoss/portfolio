@php
    //@TODO: Need to add joins for company_ids to be searched.
    use App\Models\System\Admin;

    $owner_id    = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $city        = $city ?? request()->query('city');
    $company_id  = $city ?? request()->query('company_id');
    $email       = $email ?? request()->query('email');
    $name        = $name ?? request()->query('name');
    $phone       = $phone ?? request()->query('phone');
    $state_id    = $state_id ?? request()->query('state_id');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.owner', [ 'owner_id' => $owner_id ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <?php /*
                        @TODO: Need to add joins for company_ids to be searched.
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-company', [ 'company_id' => $company_id ])
                        </div>
                        */ ?>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'phone',
                                'value'   => $phone,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-state', [ 'state_id' => $state_id ])
                        </div>
                    </div>

                </div>
                <div class="has-text-right pr-2">
                    @include('admin.components.button-clear', [
                        'id'      =>'clearSearchForm',
                        'name'    => 'Clear',
                    ])
                    @include('admin.components.button-search', [
                        'id'      =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
