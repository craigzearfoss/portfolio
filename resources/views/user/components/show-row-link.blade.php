<div class="columns">
    <span class="column is-2"><strong>{{ $name ?? '#name#' }}</strong>:</span>
    <span class="column is-10 pl-0">
        @include('user.components.link', [
            'url'    => $url ?? '',
            'name'   => $label ?? ($url ?? ''),
            'target' => $target ?? ''
        ])
    </span>
</div>
