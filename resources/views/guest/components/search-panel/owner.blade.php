@php
    use App\Models\System\Admin;

    $owner_id = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div class="control" style="max-width: 28rem;">
                @include('guest.components.form-select', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => $owner_id,
                    'list'     => new Admin()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>

        </form>

    </div>

</div>
