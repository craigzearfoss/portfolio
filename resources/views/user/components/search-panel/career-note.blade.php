@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Company;
    use App\Models\Career\Note;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action           = $action ?? url()->current();
    $application_name = $application_id ?? request()->query('application_id');
    $body             = $body ?? request()->query('body');
    $company_id       = $company_id ?? request()->query('company_id');
    $company_name     = $company_name ?? request()->query('company_name');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
    $created_at_min   = $created_at_min ?? request()->query('created_at-min');
    $favorites        = $favorites ?? request()->query('favorites');
    $owner_id         = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));    $application_id   = $application_id ?? request()->query('application_id');
    $subject          = $subject ?? request()->query('subject');
    $updated_at_max   = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min   = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Note::SEARCH_ORDER_BY[0], Note::SEARCH_ORDER_BY[1] ]);

    // get counts of companies and resumes
    // if there are more than 20 then we display an input text box instead of a select list
    $applicationCount = new Application()->query()->where('owner_id', $admin->id)->count();

    $companyCount = new Company()->query()->where('owner_id', $admin->id)->count();
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
                        'list'  => new Note()->getSortOptions($sort),
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

                        @if ($applicationCount > 20)
                            <div class="search-form-control">
                                @include('user.components.form-input', [
                                    'name'    => 'application_name',
                                    'label'   => 'application',
                                    'value'   => $application_name,
                                    'message' => $message ?? '',
                                    'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('user.components.search-panel.controls.career-application', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
                            @if ($companyCount > 20)
                                <div class="search-form-control">
                                    @include('user.components.form-input', [
                                        'name'    => 'company_name',
                                        'label'   => 'company',
                                        'value'   => $company_name,
                                        'message' => $message ?? '',
                                        'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                                    ])
                                </div>
                            @else
                                @include('user.components.search-panel.controls.career-company',
                                    [ 'owner_id' => $owner_id ]
                                )
                            @endif
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.form-input', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
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
                                'attributes' => [ 'data-resource' => 'career.note' ]
                            ])
                        </div>

                    </div>
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

                </div>

            </div>

        </form>

    </div>

</div>
