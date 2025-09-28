<div class="columns">
    <span class="column is-2"><strong>{{ $name ?? '#name#' }}</strong>:</span>
    <span class="column is-10 pl-0">
        @include('user.components.link', [
            'href'     => $href ?? '',
            'name'     => $label ?? ($href ?? ''),
            'target'   => $target ?? '',
            'download' => isset($download) ? boolval($download) : false,
        ])
    </span>
</div>
