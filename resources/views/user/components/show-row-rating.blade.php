<div class="columns">
    <div class="column is-2 text-nowrap"><strong>{{ $name ?? '#name#' }}</strong>:</div>
    <div class="column is-10 pl-0">
        @include('user.components.star-ratings', [ 'rating' => $value ?? 0 ])
    </div>
</div>
