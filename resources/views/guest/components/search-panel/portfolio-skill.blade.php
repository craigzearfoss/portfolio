@php
    use App\Models\Dictionary\Category;
    use App\Models\System\Admin;

    $action                  = $action ?? url()->current();
    $owner_id                = $owner->id ?? -1;
    $name                    = $name ?? request()->query('name');
    $min_years               = $min_years ?? request()->query('min_years');
    $years                   = $years ?? request()->query('years');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.dictionary-category')
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-skill-level', [ 'level' => $level ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
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
