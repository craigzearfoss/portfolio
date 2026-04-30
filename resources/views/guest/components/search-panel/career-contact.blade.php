@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Contact;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin = $admin ?? null;

    // get variables
    $action         = $action ?? url()->current();
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $city           = $city ?? request()->query('city');
    $company_name   = $company_name ?? request()->query('company_name');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $email          = $email ?? request()->query('email');
    $name           = $name ?? request()->query('name');
    $phone          = $phone ?? request()->query('phone');
    $state_id       = $state_id ?? request()->query('state_id');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Contact::SEARCH_ORDER_BY[0], Contact::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Contact()->getSortOptions($sort, EnvTypes::ADMIN),
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

                        <?php /*
                        @TODO: Need to add joins for company_ids to be searched.
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-company')
                        </div>
                        */ ?>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'company_name',
                                'label'   => 'company',
                                'value'   => $company_name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'phone',
                                'value'   => $phone,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                    </div>

                    <?php /*
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.system-state')
                        </div>

                    </div>
                    */ ?>

                </div>

            </div>

        </form>

    </div>

</div>
