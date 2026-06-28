@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\School;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action            = $action ?? url()->current();
    $city              = $city ?? request()->query('city');
    $community_college = $community_college ?? request()->query('community_college');
    $created_at_max    = $created_at_max ?? request()->query('created_at-max');
    $created_at_min    = $created_at_min ?? request()->query('created_at-min');
    $favorites         = $favorites ?? request()->query('favorites');
    $founded           = $founded ?? request()->query('$founded');
    $founded_max       = $founded_max ?? request()->query('founded-max');
    $founded_min       = $founded_min ?? request()->query('founded-min');
    $gender            = $gender ?? request()->query('gender');
    $hbcu              = $hbcu ?? request()->query('hbcu');
    $medical           = $medical ?? request()->query('medical');
    $name              = $name ?? request()->query('name');
    $religious         = $religious ?? request()->query('religious');
    $state_id          = $state_id ?? request()->query('state_id');
    $technical         = $technical ?? request()->query('technical');
    $type              = $type ?? request()->query('type');
    $updated_at_max    = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min    = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ School::SEARCH_ORDER_BY[0], School::SEARCH_ORDER_BY[1] ]);
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
                        'list'  => new School()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                                'class'   => [ 'input-city', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.system-state')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="control" style="max-width: 28rem;">

                            @include('admin.components.form-select', [
                                'name'     => 'type',
                                'value'    => $type,
                                'list'     => new School()->typeListOptions(true),
                                'style'    => [ 'width: 6rem' ],
                            ])
                            @include('admin.components.form-select', [
                                'name'     => 'gender',
                                'value'    => $gender,
                                'list'     => new School()->genderListOptions(true),
                                'style'    => [ 'width: 6rem' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        @include('admin.components.form-checkbox', [
                            'name'      => 'community_college',
                            'label'     => 'community college',
                            'value'     => 1,
                            'checked'   => $community_college,
                            'nohidden'  => true,
                        ])

                        @include('admin.components.form-checkbox', [
                            'name'     => 'hbcu',
                            'value'    => 1,
                            'checked'  => $hbcu,
                            'nohidden' => true,
                        ])

                        @include('admin.components.form-checkbox', [
                            'name'     => 'religious',
                            'value'    => 1,
                            'checked'  => $religious,
                            'nohidden' => true,
                        ])

                        @include('admin.components.form-checkbox', [
                            'name'     => 'technical',
                            'value'    => 1,
                            'checked'  => $technical,
                            'nohidden' => true,
                        ])

                        @include('admin.components.form-checkbox', [
                            'name'     => 'medical',
                            'value'    => 1,
                            'checked'  => $medical,
                            'nohidden' => true,
                        ])

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
                                'attributes' => [ 'data-resource' => 'portfolio.school' ]
                            ])
                        </div>

                        <div>
                            @include('admin.components.search-panel.controls.career-recruiter-founded', [
                                'founded_min' => $founded_min,
                                'founded_max' => $founded_max,
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
