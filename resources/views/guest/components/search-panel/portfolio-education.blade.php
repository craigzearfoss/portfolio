@php
    use App\Models\System\Admin;

    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $major           = $major ?? request()->query('major');
    $minor           = $minor ?? request()->query('minor');
    $school_name     = $school_name ?? request()->query('school_name');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <?php /*
                        // @TODO: too many schools for a select list
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.portfolio-school')
                        </div>
                        */ ?>
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'school_name',
                                'label'   => 'school',
                                'value'   => $school_name,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'major',
                                'value'   => $major,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'minor',
                                'value'   => $minor,
                                'message' => $message ?? '',
                            ])
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
