@php
    use App\Models\System\Admin;

    $action   = $action ?? url()->current();
    $owner_id = $owner->id ?? -1;
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">
                    <div class="floating-div">
                        @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
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
