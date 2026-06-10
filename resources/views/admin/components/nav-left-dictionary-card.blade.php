@php
    $dictionaryItems = $dictionaryItems ?? [];
    // @TODO: need to add logic to loop thru dictionary sub-items
@endphp
<div class="dictionary-button has-text-centered">
    <a href="{{ route('admin.dictionary.index') }}" class="has-text-centered">Dictionary</a>
</div>
