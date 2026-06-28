@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\Skill;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $name           = $name ?? request()->query('name');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $favorites      = $favorites ?? request()->query('favorites');
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');
    $years_min      = $years_min ?? request()->query('years-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Skill::SEARCH_ORDER_BY[0], Skill::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Skill()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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

                <div class="search-panel-body floating-div-container">

                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.dictionary-category')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.portfolio-skill-level')
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'type'    => 'number',
                                'name'    => 'years-min',
                                'label'   => 'min years',
                                'value'   => $years_min,
                                'min'     => 1,
                                'max'     => 30,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 6rem'],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="control" style="max-width: 28rem;">
                            @include('admin.components.form-checkbox', [
                                'id'         => 'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'portfolio.skill' ]
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
