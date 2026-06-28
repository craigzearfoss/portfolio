@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Contact;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $city           = $city ?? request()->query('city');
    $company_name   = $company_name ?? request()->query('company_name');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $email          = $email ?? request()->query('email');
    $favorites      = $favorites ?? request()->query('favorites');
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

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Contact()->getSortOptions($sort),
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

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('user.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif
                    */ ?>

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <?php /*
                        @TODO: Need to add joins for company_ids to be searched.
                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-company')
                        </div>
                        */ ?>

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'company_name',
                                'label'   => 'company',
                                'value'   => $company_name,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                                'class'   => [ 'input-email', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'phone',
                                'value'   => $phone,
                                'message' => $message ?? '',
                                'class'   => [ 'input-phone', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="card search-control-group">
                            @include('user.components.form-checkbox', [
                                'id'         => 'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'career.company' ]
                            ])
                        </div>

                    </div>

                    <?php /*
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.system-state')
                        </div>

                    </div>
                    */ ?>

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
