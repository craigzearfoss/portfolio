@php
    //@TODO: Need to add joins for company_ids to be searched.
    use App\Models\Career\Contact;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
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

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => array_merge($isRootAdmin ? [ 'owner.username|asc' => 'owner' ] : [],
                                               [
                                                   'created_at|desc'   => 'created at',
                                                   'name|asc'          => 'name',
                                                   //'city|asc'          => 'city',
                                                   //'state_id|asc'      => 'state',
                                                   'updated_at|desc'   => 'updated at',
                                               ],
                                   ),
                        'style' => [ 'width: 7rem', 'max-width: 7rem' ]
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

                    @if($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <?php /*
                        @TODO: Need to add joins for company_ids to be searched.
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-company')
                        </div>
                        */ ?>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'phone',
                                'value'   => $phone,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                    <?php /*
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.system-state')
                        </div>

                    </div>
                    */ ?>

                    @if($isRootAdmin)
                        <div class="floating-div">
                            @include('admin.components.search-panel.controls.timestamp-created-at', [
                                'created_at_from' => $created_at_from,
                                'created_at_to'   => $created_at_to,
                            ])
                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
