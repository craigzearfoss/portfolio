@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Company;
    use App\Models\Career\CoverLetter;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action           = $action ?? url()->current();
    $application_id   = $application_id ?? request()->query('application_id');
    $application_name = $application_id ?? request()->query('application_id');
    $application_role = $application_role ?? request()->query('application_role');
    $company_id       = $company_id ?? request()->query('company_id');
    $company_name     = $company_name ?? request()->query('company_name');
    $content          = $content ?? request()->query('content');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
    $created_at_min   = $created_at_min ?? request()->query('created_at-min');
    $description      = $description ?? request()->query('description');
    $favorites        = $favorites ?? request()->query('favorites');
    $name             = $name ?? request()->query('name');
    $notes            = $notes ?? request()->query('notes');
    $owner_id         = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $updated_at_max   = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min   = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ CoverLetter::SEARCH_ORDER_BY[0], CoverLetter::SEARCH_ORDER_BY[1] ]);

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

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new CoverLetter()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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

                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                        @if ($isRootAdmin || $applicationCount > 20)
                            <div class="search-form-control">
                                @include('admin.components.form-input', [
                                    'name'    => 'application_name',
                                    'label'   => 'application',
                                    'value'   => $application_name,
                                    'message' => $message ?? '',
                                    'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.career-application', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">

                            @if ($isRootAdmin || $companyCount > 20)
                                <div class="search-form-control">
                                    @include('admin.components.form-input', [
                                        'name'    => 'company_name',
                                        'label'   => 'company',
                                        'value'   => $company_name,
                                        'message' => $message ?? '',
                                        'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                                    ])
                                </div>
                            @else
                                @include('admin.components.search-panel.controls.career-company',
                                    $isRootAdmin ? [] : [ 'owner_id' => $owner_id ]
                                )
                            @endif

                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'application_role',
                                'label'   => 'role',
                                'value'   => $application_role,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'content',
                                'value'   => $content,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'description',
                                'value'   => $description,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'notes',
                                'value'   => $notes,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="card search-control-group">
                            @include('admin.components.form-checkbox', [
                                'id'         => 'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'career.cover_letter' ]
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
