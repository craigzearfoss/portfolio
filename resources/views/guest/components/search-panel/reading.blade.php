@php
    use App\Models\Personal\Reading;
    use App\Models\System\Admin;

    $owner_id = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $readingModel = new Reading();
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm"
              action="{!! $action ?? route('guest.personal.reading.index', !empty($owner) ? ['owner_id'=>$owner->id] : []) !!}"
              method="get">

            <div class="control" style="max-width: 28rem;">
                @include('guest.components.form-select', [
                    'name'     => 'title',
                    'value'    => Request::get('title'),
                    'list'     => $readingModel->listOptions(
                        !empty($owner->is_root) ? [] : (!empty($owner_id) ? [ 'owner_id' => $owner_id ] : []),
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
                @include('guest.components.form-select', [
                    'name'     => 'author',
                    'value'    => Request::get('author'),
                    'list'     => new Reading()->listOptions(
                        !empty($owner->is_root) ? [] : (!empty($owner) ? [ 'owner_id' => $owner->id ] : []),
                        'author',
                        'author',
                        true,
                        false,
                        [ 'author', 'asc' ]
                    ),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>

            <div style="width: 28rem; display: inline-block;">

                <div class="container control" style="width: 8rem;">
                    @include('guest.components.form-checkbox', [
                        'name'     => 'fiction',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('fiction') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

                <div class="container control" style="width: 8rem;">
                    @include('guest.components.form-checkbox', [
                        'name'     => 'nonfiction',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('nonfiction') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

                <div class="container control" style="width: 8rem;">
                    @include('guest.components.form-checkbox', [
                        'name'     => 'paper',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('paper') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

                <div class="container control" style="width: 8rem;">
                    @include('guest.components.form-checkbox', [
                        'name'     => 'audio',
                        'value'    => 1,
                        'checked'  => boolval(Request::get('audio') ?? false),
                        'nohidden' => true,
                        'onclick'  => "document.getElementById('searchForm').submit()"
                    ])
                </div>

                <div class="container control" style="width: 8rem;">
                    @include('guest.components.form-checkbox', [
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
