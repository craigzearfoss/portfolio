<div class="control sort-control">
    <div class="field">
        <div class="label">Sort by</div>
        <div class="select">
            @include('admin.components.select-list', [
                'name'  => 'sort',
                'label' => null,
                'value' => $sort ?? '',
                'list'  => $list ?? []
            ])
        </div>
    </div>
</div>
