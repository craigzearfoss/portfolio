@php
    use App\Enums\EnvTypes;
    use App\Models\System\Admin;
    use App\Models\System\Owner;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action          = $action ?? url()->current();
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
    $email           = $email ?? request()->query('email');
    $id              = $id ?? request()->query('id');
    $search_label    = $search_label ?? request()->query('search_label');
    $name            = $name ?? request()->query('name');
    $team_id         = $team_id ?? request()->query('team_id');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Owner::SEARCH_ORDER_BY[0], Owner::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Admin()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
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

                    <div class="floating-div">

                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('admin.components.form-select', [
                                    'name'  => 'id',
                                    'label' => 'username',
                                    'value' => $id,
                                    'list'  => new Admin()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                                    'style' => 'min-width: 10rem;'
                                ])
                            </div>
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'style'   => 'width: 15rem;',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'search_label',
                                'label'   => 'label',
                                'value'   => $search_label,
                                'message' => $message ?? '',
                                'style'   => 'width: 15rem;',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                                'style'   => 'width: 15rem;',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.system-admin-team')
                        </div>

                    </div>

                    @if($isRootAdmin)
                        <div class="floating-div">
                            @include('admin.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max'   => $created_at_max,
                            ])
                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
