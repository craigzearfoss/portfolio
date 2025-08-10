<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="row">
        <div class="col-2 text-nowrap"><strong>{{ $name ?? '#name#' }}</strong>:</div>
        <div class="col-10 pl-0">
            @include('front.components.checkmark', [ 'checked' => !empty($checked) ])
        </div>
    </div>
</div>
