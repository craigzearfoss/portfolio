@php
    use App\Models\Career\JobBoard;

    $action        = $action ?? url()->current();
    $name          = $name ?? request()->query('name');
    $city          = $city ?? request()->query('city');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div pl-4">
                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-recruiter-coverage_area')
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.system-state')
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
