@php
    use App\Enums\EnvTypes;
    use App\Models\System\AdminEmail;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin = $admin ?? null;

    // get variables
    $action         = $action ?? url()->current();
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $email          = $email ?? request()->query('email');
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $search_label   = $search_label ?? request()->query('label');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ AdminEmail::SEARCH_ORDER_BY[0], AdminEmail::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new AdminEmail()->getSortOptions($sort, $envTypes::USER),
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
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'label',
                                'value'   => $search_label,
                                'message' => $message ?? '',
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
