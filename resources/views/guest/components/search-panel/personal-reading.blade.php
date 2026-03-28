@php
    use App\Models\Personal\Reading;
    use App\Models\System\Admin;

    $owner_id         = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $audio            = $audio ?? request()->query('audio');
    $author           = $author ?? request()->query('author');
    $fiction          = $fiction ?? request()->query('fiction');
    $nonfiction       = $nonfiction ?? request()->query('nonfiction');
    $paper            = $paper ?? request()->query('paper');
    $searchTitleValue = $searchTitleValue ?? request()->query('searchTitleValue');
    $wishlist         = $wishlist ?? request()->query('wishlist');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
                                    'name'     => 'title',
                                    'value'    => $searchTitleValue,
                                    'list'     => new Reading()->listOptions(
                                        !empty($owner->is_root) ? [] : (!empty($owner_id) ? [ 'owner_id' => $owner_id ] : []),
                                        'title',
                                        'title',
                                        true,
                                        false,
                                        [ 'title', 'asc' ]
                                    ),
                                ])
                            </div>
                        </div>
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
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
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="floating-div pl-4">
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('guest.components.form-checkbox', [
                                    'name'     => 'fiction',
                                    'value'    => 1,
                                    'checked'  => boolval(Request::get('fiction') ?? false),
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('guest.components.form-checkbox', [
                                    'name'     => 'nonfiction',
                                    'value'    => 1,
                                    'checked'  => boolval(Request::get('nonfiction') ?? false),
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="floating-div pl-4">
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('guest.components.form-checkbox', [
                                    'name'     => 'paper',
                                    'value'    => 1,
                                    'checked'  => boolval(Request::get('paper') ?? false),
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('guest.components.form-checkbox', [
                                    'name'     => 'audio',
                                    'value'    => 1,
                                    'checked'  => boolval(Request::get('audio') ?? false),
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>
                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('guest.components.form-checkbox', [
                                    'name'     => 'wishlist',
                                    'value'    => 1,
                                    'checked'  => boolval(Request::get('wishlist') ?? false),
                                    'nohidden' => true,
                                ])
                            </div>
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
