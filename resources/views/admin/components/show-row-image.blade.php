<div class="columns">
    <span class="column is-2 text-nowrap"><strong>{{ $name ?? '#name#' }}</strong>:</span>
    <span class="column is-10 pl-0">
        @include('admin.components.image', [
            'url'    => $url ?? ''
        ])
    </span>
</div>
