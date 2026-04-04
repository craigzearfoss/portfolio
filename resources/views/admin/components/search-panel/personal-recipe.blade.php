@php
    use App\Models\System\Admin;

    $action          = $action ?? url()->current();
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $author          = $author ?? request()->query('author');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $name            = $name ?? request()->query('name');
    $prep_time       = $prep_time ?? request()->query('prep_time');
    $total_time      = $total_time ?? request()->query('total_time');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'author',
                                'value'   => $author,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.personal-recipe-type')
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.personal-recipe-meal')
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'prep_time',
                                'label'   => 'max prep time (minutes)',
                                'value'   => $prep_time,
                                'message' => $message ?? '',
                                'style'   => 'width: 5rem;',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'total_time',
                                'label'   => 'max total time (minutes)',
                                'value'   => $total_time,
                                'message' => $message ?? '',
                                'style'   => 'width: 5rem;',
                            ])
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
