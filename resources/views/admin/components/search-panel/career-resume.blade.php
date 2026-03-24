@php
    use App\Models\System\Admin;

    $owner_id = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $name     = $name ?? request()->query('name');
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
