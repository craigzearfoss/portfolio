@php
    use App\Enums\EnvTypes;
    use App\Models\System\Message;

    // get variables
    $action          = $action ?? url()->current();
    $name            = $name ?? request()->query('name');
    $email           = $email ?? request()->query('email');
    $subject         = $subject ?? request()->query('subject');
    $body            = $body ?? request()->query('body');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');

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

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'style'   => 'width: 15rem;',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                                'style'   => 'width: 15rem;',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                                'style'   => 'width: 15rem;',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.form-input', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                                'style'   => 'width: 15rem;',
                            ])
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
