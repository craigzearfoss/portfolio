@php
    use App\Models\System\Admin;

    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $credit          = $credit ?? request()->query('credit');
    $name            = $name ?? request()->query('name');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('user.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'credit',
                                'value'   => $credit,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        @include('user.components.search-panel.controls.timestamp-created-at', [
                            'created_at_from' => $created_at_from,
                            'created_at_to'   => $created_at_to,
                        ])
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('user.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('user.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
