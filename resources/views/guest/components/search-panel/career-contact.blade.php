@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Contact;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $city            = $city ?? request()->query('city');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $email           = $email ?? request()->query('email');
    $name            = $name ?? request()->query('name');
    $phone           = $phone ?? request()->query('phone');
    $state_id        = $state_id ?? request()->query('state_id');

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
                        'list'  => new Contact()->getSearchOptions($sort, EnvTypes::GUEST),
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
                            @include('guest.components.form-input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
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
                            @include('guest.components.form-input', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'phone',
                                'value'   => $phone,
                                'message' => $message ?? '',
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
