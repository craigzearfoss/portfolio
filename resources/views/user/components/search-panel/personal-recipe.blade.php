@php
    use App\Enums\EnvTypes;
    use App\Models\Personal\Recipe;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $author          = $author ?? request()->query('author');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
    $name            = $name ?? request()->query('name');
    $prep_time       = $prep_time ?? request()->query('prep_time');
    $total_time      = $total_time ?? request()->query('total_time');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Recipe::SEARCH_ORDER_BY[0], Recipe::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Recipe()->getSortOptions($sort, EnvTypes::GUEST),
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
                            @include('user.components.input', [
                                'name'    => 'author',
                                'value'   => $author,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.personal-recipe-type')
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.personal-recipe-meal')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'prep_time',
                                'label'   => 'prep time',
                                'value'   => $prep_time,
                                'message' => $message ?? '',
                                'style'   => 'width: 5rem;',
                                'title'   => 'Minimum prep time in minutes.',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'total_time',
                                'label'   => 'total time',
                                'value'   => $total_time,
                                'message' => $message ?? '',
                                'style'   => 'width: 5rem;',
                                'title'   => 'Minimum total time in minutes.',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
