@php
    use App\Models\Personal\Reading;
    use App\Models\System\Admin;
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm"
              action="{!! $action ?? route('admin.personal.reading.index', !empty($owner) ? ['owner_id'=>$owner->id] : []) !!}"
              method="get">

            @if(isRootAdmin())
                <div class="control" style="max-width: 28rem;">
                    @include('admin.components.form-select', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => !empty($owner->root) ? null : ($owner->id ?? null),
                        'list'     => new Admin()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                        'onchange' => "document.getElementById('searchForm').submit()"
                    ])
                </div>
            @endif

            <div class="control" style="max-width: 28rem;">
                @include('admin.components.form-select', [
                    'name'     => 'title',
                    'value'    => Request::get('title'),
                    'list'     => new Reading()->listOptions(
                        !empty($owner->root) ? [] : (!empty($owner) ? [ 'owner_id' => $owner->id ] : []),
                        'title',
                        'title',
                        true,
                        false,
                        [ 'title', 'asc' ]
                    ),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>

            <div class="control" style="max-width: 28rem;">
                @include('admin.components.form-select', [
                    'name'     => 'author',
                    'value'    => Request::get('author'),
                    'list'     => new Reading()->listOptions(!empty($owner->root) ? [] : (!empty($owner) ? [ 'owner_id' => $owner->id ] : []), 'author', 'author', true, false, [ 'author', 'asc' ]),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>

            <div style="width: 28rem; display: inline-block;">

                <div class="container control" style="width: 8rem;">
                    @include('admin.components.form-checkbox', [
                        'name'     => 'fiction',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('fiction') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

                <div class="container control" style="width: 8rem;">
                    @include('admin.components.form-checkbox', [
                        'name'     => 'nonfiction',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('nonfiction') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

                <div class="container control" style="width: 8rem;">
                    @include('admin.components.form-checkbox', [
                        'name'     => 'paper',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('paper') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

                <div class="container control" style="width: 8rem;">
                    @include('admin.components.form-checkbox', [
                        'name'     => 'audio',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('audio') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

                <div class="container control" style="width: 8rem;">
                    @include('admin.components.form-checkbox', [
                        'name'     => 'wishlist',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('wishlist') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

            </div>
        </form>
    </div>

</div>
