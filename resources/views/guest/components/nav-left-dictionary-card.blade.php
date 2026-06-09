@php
    $dictionaryItems = $dictionaryItems ?? [];
    // @TODO: need to add logic to loop thru dictionary sub-items
@endphp
<div class="dictionary-button has-text-centered">
    <a href="{{ route('guest.dictionary.index') }}" class="has-text-centered p-1 m-1">Dictionary</a>
</div>
