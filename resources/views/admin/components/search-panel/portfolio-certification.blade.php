@php
    use App\Models\Career\JobBoard;

    $action          = $action ?? url()->current();
    $abbreviation    = $abbreviation ?? request()->query('abbreviation');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $name            = $name ?? request()->query('name');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div pl-4">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'abbreviation',
                                'value'   => $abbreviation,
                                'message' => $message ?? '',
                                'style'   => 'width: 6rem;',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.portfolio-certification-certification_type')
                        </div>
                    </div>

                    <div class="floating-div" style="display: none;">
                        @include('admin.components.search-panel.controls.timestamp-created-at', [
                            'created_at_from' => $created_at_from,
                            'created_at_to'   => $created_at_to,
                        ])
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
