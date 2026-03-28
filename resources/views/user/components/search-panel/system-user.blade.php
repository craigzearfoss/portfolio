@php
    use App\Models\System\User;

    $user_id = $user_id ?? $user->id ?? null;
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="control" style="max-width: 28rem;">
                            @include('user.components.form-select', [
                                'name'     => 'user_id',
                                'label'    => 'user',
                                'value'    => $user_id,
                                'list'     => new User()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                            ])
                        </div>
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('user.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('user.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
