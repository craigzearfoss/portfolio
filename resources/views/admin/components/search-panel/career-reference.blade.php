@php
    use App\Models\Career\Reference;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $city            = $city ?? request()->query('city');
    $company_name    = $company_name ?? request()->query('company_name');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $email           = $email ?? request()->query('email');
    $name            = $name ?? request()->query('name');
    $phone           = $phone ?? request()->query('phone');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Reference::SEARCH_ORDER_BY[0], Reference::SEARCH_ORDER_BY[1] ]);
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
                                                   'company_name|asc' => 'company',
                                                   'created_at|desc'  => 'created at',
                                                   'email|asc'        => 'email',
                                                   'name|asc'         => 'name',
                                                   'phone|asc'        => 'phone',
                                                   'updated_at|desc'  => 'updated at',
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
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-reference-relation', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'phone',
                                'value'   => $phone,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.system-state')
                        </div>

                    </div>

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
