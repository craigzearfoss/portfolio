<div class="columns">
    <div class="column is-2 text-nowrap"><strong>{{ !empty($name) ? $name : '' }}</strong>:</div>
    <div class="column is-10 pl-0">
        @include('admin.components.list', [
            'values' => $values ?? []
        ])
    </div>
</div>
