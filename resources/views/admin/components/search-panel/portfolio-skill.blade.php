@php
    use App\Models\Dictionary\Category;
    use App\Models\System\Admin;

    $owner_id                = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $name                    = $name ?? request()->query('name');
    $dictionary_category_id  = $dictionary_category_id ?? request()->query('dictionary_category_id');
    $level                   = $level ?? request()->query('level');
    $min_years               = $min_years ?? request()->query('min_years');
    $years                   = $years ?? request()->query('years');
    $created_at_from         = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
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
                            @include('admin.components.search-panel.controls.dictionary-category', [
                                'dictionary_category_id' => $dictionary_category_id
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.portfolio-skill-level', [ 'level' => $level ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'type'    => 'number',
                                'name'    => 'min_years',
                                'label'    => 'min years',
                                'value'   => $min_years,
                                'min'     => 1,
                                'max'     => 30,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        @include('admin.components.search-panel.controls.timestamp-created-at', [
                            'created_at_from' => $created_at_from,
                            'created_at_to'   => $created_at_to,
                        ])
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
