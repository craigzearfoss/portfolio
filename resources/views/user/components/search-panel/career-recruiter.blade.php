@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Recruiter;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action                = $action ?? url()->current();
    $city                  = $city ?? request()->query('city');
    $country_id            = $country_id ?? request()->query('country_id');
    $created_at_max        = $created_at_max ?? request()->query('created_at-max');
    $created_at_min        = $created_at_min ?? request()->query('created_at-min');
    $email                 = $email ?? request()->query('email');
    $favorites             = $favorites ?? request()->query('favorites');
    $founded               = $founded ?? request()->query('$founded');
    $founded_max           = $founded_max ?? request()->query('founded-max');
    $founded_min           = $founded_min ?? request()->query('founded-min');
    $international         = $international ?? request()->query('international');
    $is_active             = $is_active ?? request()->query('is_active');
    $is_disabled           = $is_disabled ?? request()->query('is_disabled');
    $local                 = $local ?? request()->query('local');
    $name                  = $name ?? request()->query('name');
    $national              = $national ?? request()->query('national');
    $phone                 = $phone ?? request()->query('phone');
    $primary               = $primary ?? request()->query('primary');
    $recruiter_industry_id = $recruiter_industry_id ?? request()->query('recruiter_industry_id');
    $regional              = $regional ?? request()->query('regional');
    $specialties           = $specialties ?? request()->query('specialties');
    $state_id              = $state_id ?? request()->query('state_id');
    $updated_at_max        = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min        = $updated_at_min ?? request()->query('updated_at-min');
    $zip                   = $zip ?? request()->query('zip');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Recruiter::SEARCH_ORDER_BY[0], Recruiter::SEARCH_ORDER_BY[1] ]);
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
                        'list'  => new Recruiter()->getSortOptions($sort, EnvTypes::GUEST),
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
                            @include('user.components.form-input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-recruiter-industry')
                        </div>

                        <div class="search-form-control">
                            @include('user.components.form-input', [
                                'name'    => 'specialties',
                                'label'   => 'specialty',
                                'value'   => $specialties,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        @include('user.components.search-panel.controls.career-recruiter-coverage-area', [
                            'local'         => $local,
                            'regional'      => $regional,
                            'national'      => $national,
                            'international' => $international,
                        ])

                    </div>
                    <div class="floating-div" style="width: 12rem;">

                        <div class="card search-control-group">

                            @include('user.components.form-checkbox', [
                                'id'         =>'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'career.recruiter' ]
                            ])

                            @include('user.components.form-checkbox', [
                                'name'     => 'primary',
                                'value'    => 1,
                                'checked'  => $primary,
                                'nohidden' => true,
                            ])

                            @include('user.components.form-checkbox', [
                                'name'     => 'is_active',
                                'label'    => 'active',
                                'value'    => 1,
                                'checked'  => $is_active,
                                'nohidden' => true,
                            ])

                            @include('user.components.form-checkbox', [
                                'name'     => 'is_disabled',
                                'label'    => 'disabled',
                                'value'    => 1,
                                'checked'  => $is_disabled,
                                'nohidden' => true,
                            ])

                            <div>
                                @include('user.components.search-panel.controls.career-recruiter-founded', [
                                    'founded_min' => $founded_min,
                                    'founded_max' => $founded_max,
                                ])
                            </div>

                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                                'class'   => [ 'input-city', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.system-state')
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.system-country')
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
