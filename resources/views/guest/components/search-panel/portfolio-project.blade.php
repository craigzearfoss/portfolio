@php
    use App\Models\Portfolio\Project;
    use App\Models\System\Admin;

    // get variables
    $action     = $action ?? url()->current();
    $owner_id   = $owner->id ?? -1;
    $language   = $language ?? request()->query('language');
    $name       = $name ?? request()->query('name');
    $repository = $repository ?? request()->query('repository');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Project::SEARCH_ORDER_BY[0], Project::SEARCH_ORDER_BY[1] ]);
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
                            @include('guest.components.input-basic', [
                                'name'    => 'language',
                                'value'   => $language,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'repository',
                                'value'   => $repository,
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
