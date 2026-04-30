@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Company;
    use App\Models\Career\Event;
    use App\Models\System\Admin;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action             = $action ?? url()->current();
    $application_id     = $application_id ?? request()->query('application_id');
    $application_name   = $application_id ?? request()->query('application_id');
    $attendees          = $attendees ?? request()->query('attendees');
    $company_id         = $company_id ?? request()->query('company_id');
    $company_name       = $company_name ?? request()->query('company_name');
    $created_at_max     = $created_at_max ?? request()->query('created_at-max');
    $created_at_min     = $created_at_min ?? request()->query('created_at-min');
    $description        = $description ?? request()->query('description');
    $event_datetime_max = $event_datetime_max ?? request()->query('event_datetime_max');
    $event_datetime_min = $event_datetime_min ?? request()->query('event_datetime_min');
    $location           = $location ?? request()->query('location');
    $name               = $name ?? request()->query('name');
    $owner_id           = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $updated_at_max     = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min     = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Event::SEARCH_ORDER_BY[0], Event::SEARCH_ORDER_BY[1] ]);

    // get counts of companies and resumes
    // if there are more than 20 then we display an input text box instead of a select list
    $applicationCount = $isRootAdmin
        ? new Application()->query()->count()
        : new Application()->query()->where('owner_id', $admin->id)->count();

    $companyCount = $isRootAdmin
        ? new Company()->query()->count()
        : new Company()->query()->where('owner_id', $admin->id)->count();
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Event()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
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

                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        @if($isRootAdmin || $applicationCount > 20)
                            <div class="search-form-control">
                                @include('guest.components.form-input-with-icon', [
                                    'name'    => 'application_name',
                                    'label'   => 'application',
                                    'value'   => $application_name,
                                    'message' => $message ?? '',
                                    'style'   => [ 'width: 12rem' ],
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.career-application', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
                            @if($isRootAdmin || $companyCount > 20)
                                <div class="search-form-control">
                                    @include('guest.components.form-input-with-icon', [
                                        'name'    => 'company_name',
                                        'label'   => 'company',
                                        'value'   => $company_name,
                                        'message' => $message ?? '',
                                    ])
                                </div>
                            @else
                                @include('guest.components.search-panel.controls.career-company',
                                    $isRootAdmin ? [] : [ 'owner_id' => $owner_id ]
                                )
                            @endif
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'description',
                                'value'   => $description,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'location',
                                'value'   => $location,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'attendees',
                                'value'   => $attendees,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        @include('guest.components.search-panel.controls.career-event-event-datetime', [
                            'event-datetime-min' => $event_datetime_min,
                            'event-datetime-max' => $event_datetime_max,
                        ])

                    </div>

                    @if($isRootAdmin)
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

                </div>

            </div>

        </form>

    </div>

</div>
