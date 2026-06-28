@php
    use App\Enums\EnvTypes;
    use App\Models\System\Admin;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $email          = $email ?? request()->query('email');
    $favorites      = $favorites ?? request()->query('favorites');
    $name           = $name ?? request()->query('name');
    $search_label   = $search_label ?? request()->query('label');
    $team_id        = $team_id ?? request()->query('team_id');
    $this_admin_id  = $isRootAdmin
        ? $this_admin_id ?? request()->query('id')
        : $admin->id;
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Owner::SEARCH_ORDER_BY[0], Owner::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Admin()->getSortOptions($sort),
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

                <div class="search-panel-body floating-div-container">

                    <div class="floating-div">

                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('user.components.form-select', [
                                    'name'  => 'id',
                                    'label' => 'username',
                                    'value' => $this_admin_id,
                                    'list'  => new Admin()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                                    'style' => 'min-width: 10rem;'
                                ])
                            </div>
                        </div>

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 15rem;',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'label',
                                'value'   => $search_label,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 15rem;',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => 'width: 15rem;',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.system-admin-team')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="control" style="max-width: 28rem;">
                            @include('user.components.form-checkbox', [
                                'id'         => 'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'system.admin' ]
                            ])
                        </div>

                    </div>

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">

                            @include('user.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('user.components.search-panel.controls.timestamp-updated-at', [
                                'updated_at-min' => $updated_at_min,
                                'updated_at-max' => $updated_at_max,
                            ])

                        </div>
                    @endif
                    */ ?>

                </div>

            </div>

        </form>

    </div>

</div>
