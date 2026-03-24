@php
    use App\Models\System\Admin;

    $owner_id = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $body     = $body ?? request()->query('body');
    $subject  = $subject ?? request()->query('subject');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.owner', [ 'owner_id' => $owner_id ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('guest.components.button-clear', [
                        'id'      =>'clearSearchForm',
                        'name'    => 'Clear',
                    ])
                    @include('guest.components.button-search', [
                        'id'      =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
