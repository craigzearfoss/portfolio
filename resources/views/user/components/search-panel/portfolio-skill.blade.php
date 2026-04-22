@php
    use App\Enums\EnvTypes;
    use App\Models\Dictionary\Category;
    use App\Models\Portfolio\Skill;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id         = $owner->id ?? -1;
    $name            = $name ?? request()->query('name');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $min_years       = $min_years ?? request()->query('min_years');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Skill::SEARCH_ORDER_BY[0], Skill::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Skill()->getSortOptions($sort, EnvTypes::GUEST),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('user.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('user.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.dictionary-category')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.portfolio-skill-level')
                        </div>

                    </div>

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input', [
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

            </div>

        </form>

    </div>

</div>
