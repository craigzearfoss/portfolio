@php
    use App\Models\Dictionary\Category;

    $dictionary_category_id = $dictionary_category_id ?? request()->query('dictionary_category_id');
@endphp
<div class="control" style="max-width: 10rem;">
    @include('user.components.form-select', [
        'name'     => 'dictionary_category_id',
        'label'    => 'category',
        'value'    => $dictionary_category_id,
        'list'     => new Category()->listOptions([], 'id', 'name', true),
        'style'    => 'width: 19rem;'
    ])
</div>
