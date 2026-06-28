@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Resume;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $active         = $active ?? request()->query('active');
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $favorites      = $favorites ?? request()->query('favorites');
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

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header" style="width: 25rem;">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Resume()->getSortOptions($sort),
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

                <div class="search-panel-body floating-div-container">

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif
                    */ ?>

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="card search-control-group">

                            @include('guest.components.form-checkbox', [
                                'name'     => 'active',
                                'value'    => 1,
                                'checked'  => $active,
                                'nohidden' => true,
                            ])

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

                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-checkbox', [
                                    'id'         => 'favoritesCheckBox',
                                    'name'       => 'favorites',
                                    'value'      => 1,
                                    'checked'    => $favorites,
                                    'nohidden'   => true,
                                    'class'      => [ 'search-favorites' ],
                                    'attributes' => [ 'data-resource' => 'career.resume' ]
                                ])
                            </div>

                        </div>

                    </div>

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">

                            @include('guest.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('guest.components.search-panel.controls.timestamp-updated-at', [
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
