@if(!empty($value))
    <article class="message is-danger" style="display: inline-block;">
        <div class="message-body p-1">
            {!! $value !!}
        </div>
        <div class="message-body p-0">
        </div>
    </article>
@endif
