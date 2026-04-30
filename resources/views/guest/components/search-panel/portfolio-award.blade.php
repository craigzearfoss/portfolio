@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\Award;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin = $admin ?? null;

    // get variables
    $action         = $action ?? url()->current();
    $category       = $category ?? request()->query('category');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $name           = $name ?? request()->query('name');
    $nominated_work = $nominated_work ?? request()->query('nominated_work');
    $organization   = $organization ?? request()->query('organization');
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Award::SEARCH_ORDER_BY[0], Award::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Award()->getSortOptions($sort, EnvTypes::ADMIN),
				        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('guest.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('guest.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'category',
                                'value'   => $category,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'nominated_work',
                                'label'   => 'nominated work',
                                'value'   => $nominated_work,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'organization',
                                'value'   => $organization,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
