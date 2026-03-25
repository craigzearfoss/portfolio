@php
    use App\Models\System\User;

    $user_id = $user_id ?? $user->id ?? null;
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div class="control" style="max-width: 28rem;">
                @include('guest.components.form-select', [
                    'name'     => 'user_id',
                    'label'    => 'user',
                    'value'    => $user_id,
                    'list'     => new User()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>

        </form>

    </div>

</div>
