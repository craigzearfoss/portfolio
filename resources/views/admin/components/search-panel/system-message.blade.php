@php
    use App\Enums\EnvTypes;
    use App\Models\System\Message;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $body           = $body ?? request()->query('body');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $email          = $email ?? request()->query('email');
    $name           = $name ?? request()->query('name');
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $subject        = $subject ?? request()->query('subject');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Message::SEARCH_ORDER_BY[0], Message::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

                <div class="search-panel-controls">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Message()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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

            <div>

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
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                                'style'   => 'width: 12rem;',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                                'style'   => 'width: 12rem;',
                            ])
                        </div>

                    </div>

                    @if($isRootAdmin)
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
