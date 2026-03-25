@php
    use App\Models\System\Admin;

    $owner_id  = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $body      = $body ?? request()->query('body');
    $date_from = $date_from ?? request()->query('date_from');
    $date_to   = $date_to ?? request()->query('date_to');
    $from      = $from ?? request()->query('from');
    $subject   = $subject ?? request()->query('subject');
    $to        = $to ?? request()->query('to');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

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
                            @include('admin.components.input-basic', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'from',
                                'value'   => $from,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'to',
                                'value'   => $to,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'from_date',
                                'label'   => 'from date',
                                'value'   => $date_from,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'to_date',
                                'label'   => 'to date',
                                'value'   => $date_to,
                                'message' => $message ?? '',
                            ])
                        </div>
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
