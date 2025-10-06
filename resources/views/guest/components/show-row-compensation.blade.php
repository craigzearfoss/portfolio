<div class="columns">
    <div class="column is-2"><strong>{{ $name ?? '#name#' }}</strong>:</div>
    <div class="column is-10 pl-0">
        @if ($value)
            {{ explode('.', Number::currency($value))[0] }}
            @if ($unit)
                / {{ $unit }}
            @endif
        @else
            ?
        @endif
    </div>
</div>
