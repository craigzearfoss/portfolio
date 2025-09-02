<div class="columns">
    <div class="column is-2 text-nowrap"><strong>{{ isset($name) ? $name : '#name#' }}</strong>:</div>
    <div class="column is-10 pl-0">{!! $value ?? '' !!}</div>
</div>
