@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Resume;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin = $admin ?? null;

    // get variables
    $action         = $action ?? url()->current();
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $is_public      = $is_public ?? request()->query('is_public');
    $name           = $name ?? request()->query('name');
    $primary        = $primary ?? request()->query('primary');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Resume::SEARCH_ORDER_BY[0], Resume::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls" style="width: 25rem;">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Resume()->getSortOptions($sort, EnvTypes::ADMIN),
                        'style' => [ 'width: 10rem', 'max-width: 10rem' ]
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
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        @include('guest.components.form-checkbox', [
                            'name'     => 'primary',
                            'value'    => 1,
                            'checked'  => $primary,
                            'nohidden' => true,
                        ])

                        @include('guest.components.form-checkbox', [
                            'name'     => 'is_public',
                            'label'    => 'public',
                            'value'    => 1,
                            'checked'  => $is_public,
                            'nohidden' => true,
                        ])

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
