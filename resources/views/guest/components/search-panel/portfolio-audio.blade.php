@php
    use App\Models\Portfolio\Audio;
    use App\Models\System\Admin;

    // get variables
    $action     = $action ?? url()->current();
    $owner_id   = $owner->id ?? -1;
    $audio_type = $audio_type ?? request()->query('audio_type');
    $name       = $name ?? request()->query('name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Audio::SEARCH_ORDER_BY[0], Audio::SEARCH_ORDER_BY[1] ]);
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
                            @include('guest.components.search-panel.controls.portfolio-audio-audio_type', [ 'owner_id' => $owner_id ])
                        </div>
                    </div>

                </div>

                <div class="has-text-right pr-2">

                    @include('guest.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => [
                                    'name|asc' => 'name',
                                    'type|asc' => 'type',
                                    'year|asc' => 'year',
                                  ]
                    ])

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
