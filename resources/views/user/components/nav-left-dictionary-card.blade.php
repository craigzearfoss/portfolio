@php
    $dictionaryItems = $dictionaryItems ?? [];
    // @TODO: need to add logic to loop thru dictionary sub-items
@endphp
<div class="dictionary-button has-text-centered">
    <a href="{{ route('user.dictionary.index') }}" class="has-text-centered">Dictionary</a>
</div>
