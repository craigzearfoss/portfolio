@php
    use App\Models\System\User;
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div class="control" style="max-width: 28rem;">
                @include('admin.components.form-select', [
                    'name'     => 'user_id',
                    'label'    => 'user',
                    'value'    => $user->id ?? null,
                    'list'     => new User()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'onchange' => "document.getElementById('searchForm').submit()"
                ])
            </div>

        </form>

    </div>

</div>
