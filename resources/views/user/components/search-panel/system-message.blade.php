@php
    use App\Models\System\Admin;
    use App\Models\System\Message;

    // get variables
    $action          = $action ?? url()->current();
    $name            = $name ?? request()->query('name');
    $email           = $email ?? request()->query('email');
    $subject         = $subject ?? request()->query('subject');
    $body            = $body ?? request()->query('body');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Message::SEARCH_ORDER_BY[0], Message::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Message()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
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

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
