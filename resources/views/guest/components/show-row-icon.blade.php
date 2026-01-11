<div class="columns">
    <div class="column is-2"><strong>{{ $name ?? '' }}</strong>:</div>
    <div class="column is-10 pl-0">
        @include('guest.components.icon', [ 'icon' => $icon ?? '' ])
    </div>
</div>
