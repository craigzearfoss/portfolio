<div class="select-container">
    <div class="select-label">Sort by</div>
    <div class="select-list">
        @include('guest.components.form-select', [
            'name'  => 'sort',
            'label' => null,
            'value' => $sort ?? '',
            'list'  => $list ?? []
        ])
    </div>
</div>
