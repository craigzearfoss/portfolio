@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\Education;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action          = $action ?? url()->current();
    $created_at_max  = $created_at_max ?? request()->query('created_at-max');
    $created_at_min  = $created_at_min ?? request()->query('created_at-min');
    $enrollment_date = $enrollment_date ?? request()->query('enrollment_date');
    $favorites       = $favorites ?? request()->query('favorites');
    $graduation_date = $graduation_date ?? request()->query('graduation_date');
    $major           = $major ?? request()->query('major');
    $minor           = $minor ?? request()->query('minor');
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $school_name     = $school_name ?? request()->query('school_name');
    $updated_at_max  = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min  = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Education::SEARCH_ORDER_BY[0], Education::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Education()->getSortOptions($sort),
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

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif
                    */ ?>

                    <div class="floating-div">

                        <?php /*
                        // @TODO: too many schools for a select list
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-school')
                        </div>
                        */ ?>

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'school_name',
                                'label'   => 'school',
                                'value'   => $school_name,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-education-degree-type', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'major',
                                'value'   => $major,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'minor',
                                'value'   => $minor,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="control" style="max-width: 30rem;">
                            @include('guest.components.form-checkbox', [
                                'id'         => 'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'portfolio.education' ]
                            ])
                        </div>

                    </div>

                    <?php /*
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
                    */ ?>

                </div>

            </div>

        </form>

    </div>

</div>
