@php
    use App\Models\Personal\Reading;
    use App\Models\System\Admin;

    $action             = $action ?? url()->current();
    $owner_id           = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $audio              = boolval($audio ?? request()->query('audio'));
    $author             = $author ?? request()->query('author');
    $created_at_from    = $created_at_from ?? request()->query('created_at_from');
    $created_at_to      = $created_at_to ?? request()->query('created_at_to');
    $fiction            = boolval($fiction ?? request()->query('fiction'));
    $nonfiction         = boolval($nonfiction ?? request()->query('nonfiction'));
    $paper              = boolval($paper ?? request()->query('paper'));
    $search_title_value = $search_title_value ?? request()->query('search_title_value');
    $wishlist           = boolval($wishlist ?? request()->query('wishlist'));
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
                            <div class="control" style="max-width: 28rem;">
                                @include('admin.components.form-select', [
                                    'name'     => 'title',
                                    'value'    => $search_title_value,
                                    'list'     => new Reading()->listOptions(
                                        !empty($owner->is_root) ? [] : (!empty($owner_id) ? [ 'owner_id' => $owner_id ] : []),
                                        'title',
                                        'title',
                                        true,
                                        false,
                                        [ 'title', 'asc' ],
                                    ),
                                    'style'    => 'min-width: 15rem;'
                                ])
                            </div>
                        </div>
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('admin.components.form-select', [
                                    'name'     => 'author',
                                    'value'    => $author,
                                    'list'     => new Reading()->listOptions(
                                        !empty($owner->is_root) ? [] : (!empty($owner) ? [ 'owner_id' => $owner->id ] : []),
                                        'author',
                                        'author',
                                        true,
                                        false,
                                        [ 'author', 'asc' ]
                                    ),
                                    'style'    => 'min-width: 15rem;'
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="floating-div pl-4">
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'fiction',
                                    'value'    => 1,
                                    'checked'  => $fiction,
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'nonfiction',
                                    'value'    => 1,
                                    'checked'  => $nonfiction,
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="floating-div pl-4">
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'paper',
                                    'value'    => 1,
                                    'checked'  => $paper,
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'audio',
                                    'value'    => 1,
                                    'checked'  => $audio,
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'wishlist',
                                    'value'    => 1,
                                    'checked'  => $wishlist,
                                    'nohidden' => true,
                                ])
                            </div>
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
