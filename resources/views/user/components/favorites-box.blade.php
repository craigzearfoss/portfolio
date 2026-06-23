<div class="card favorites-box m-1" style="width: 5rem;display: block; position: absolute; top: 0; right: 0;">
    <div class="card-header pl-2 pr-1 has-background-grey-light">
        {{ $label ?? 'favorites' }}
    </div>
    <div class="card-body has-background-white has-text-centered">
        {{ $count ?? 0 }}
    </div>
</div>
