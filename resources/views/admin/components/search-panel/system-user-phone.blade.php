@php
    use App\Enums\EnvTypes;
    use App\Models\System\User;
    use App\Models\System\UserPhone;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $favorites      = $favorites ?? request()->query('favorites');
    $phone          = $phone ?? request()->query('phone');
    $search_label   = $search_label ?? request()->query('label');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');
    $user_id        = $user_id ?? $user->id ?? request()->query('user_id');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ UserPhone::SEARCH_ORDER_BY[0], UserPhone::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new UserPhone()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        <div class="control" style="max-width: 30rem;">
                            @include('admin.components.form-select', [
                                'name'  => 'user_id',
                                'label' => 'owning user',
                                'value' => $user_id,
                                'list'  => new User()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                                'style' => 'min-width: 10rem;'
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'phone',
                                'value'   => $phone,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 15rem;',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'label',
                                'value'   => $search_label,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 15rem;',
                            ])
                        </div>

                    </div>

                    @if ($isRootAdmin)
                        <div class="floating-div">

                            @include('admin.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('admin.components.search-panel.controls.timestamp-updated-at', [
                                'updated_at-min' => $updated_at_min,
                                'updated_at-max' => $updated_at_max,
                            ])

                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
