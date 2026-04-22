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
    $action           = $action ?? url()->current();
    $owner_id         = $owner->id ?? -1;
    $application_id   = $application_id ?? request()->query('application_id');
    $application_name = $application_id ?? request()->query('application_id');
    $attendees        = $attendees ?? request()->query('attendees');
    $company_id       = $company_id ?? request()->query('company_id');
    $company_name     = $company_name ?? request()->query('company_name');
    $created_at_from  = $created_at_from ?? request()->query('created_at_from');
    $created_at_to    = $created_at_to ?? request()->query('created_at_to');
    $date_from        = $datetime_from ?? request()->query('date_from');
    $date_to          = $datetime_to ?? request()->query('date_to');
    $time_from        = $date_from ?? request()->query('time_from');
    $time_to          = $time_to ?? request()->query('time_to');
    $description      = $description ?? request()->query('description');
    $name             = $name ?? request()->query('name');
    $location         = $location ?? request()->query('location');

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
                        'list'  => new Event()->getSortOptions($sort, EnvTypes::GUEST),
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

                    @if($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        @if($applicationCount > 20)
                            <div class="search-form-control">
                                @include('guest.components.form-input', [
                                    'name'    => 'application_name',
                                    'label'   => 'application',
                                    'value'   => $application_name,
                                    'message' => $message ?? '',
                                    'style'   => 'width: 16rem;'
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.career-application', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
                            @if($companyCount > 20)
                                <div class="search-form-control">
                                    @include('guest.components.form-input', [
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
                            @include('guest.components.form-input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'description',
                                'value'   => $description,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'location',
                                'value'   => $location,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'attendees',
                                'value'   => $attendees,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'type'    => 'date',
                                'name'    => 'date_from',
                                'label'   => 'from date',
                                'value'   => $date_from,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'type'    => 'date',
                                'name'    => 'date_to',
                                'label'   => 'to date',
                                'value'   => $date_to,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'type'    => 'time',
                                'name'    => 'time_from',
                                'label'   => 'from time',
                                'value'   => $time_from,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'type'    => 'time',
                                'name'    => 'time_to',
                                'label'   => 'to time',
                                'value'   => $time_to,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
