@php
    use App\Models\System\Admin;

    $action      = $action ?? url()->current();
    $owner_id    = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $city        = $city ?? request()->query('city');
    $email       = $email ?? request()->query('email');
    $name        = $name ?? request()->query('name');
    $phone       = $phone ?? request()->query('phone');
    $relation    = $relation ?? request()->query('relation');
    $state_id    = $state_id ?? request()->query('state_id');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    @if($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-reference-relation', [ 'owner_id' => $owner_id ])
                        </div>
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
                            @include('admin.components.search-panel.controls.system-state', [ 'state_id' => $state_id ])
                        </div>
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
