@php
    use App\Models\Career\JobBoard;

    $name     = $name ?? request()->query('name');
    $coverage = $coverage ?? request()->query('coverage');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div pl-4">
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-job-board-coverage', [ 'coverage' => $coverage ])
                        </div>
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('guest.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('guest.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>
        </form>
    </div>

</div>
