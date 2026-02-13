<section class="hero is-hero-bar">

    <div class="subtitle-bar hero-body p-3">
        <div class="level">

            <div class="level-left" style="display: inline-block;">
                <div class="level-item">
                    <h1 class="title is-size-4">
                        {!! $title ?? '' !!}
                    </h1>
                    @if(!empty($selectList))
                        <span class="ml-2">
                            {!! $selectList !!}
                        </span>
                    @endif
                </div>
            </div>

            <div class="level-right" style="display: inline-block;">
                @if (!empty($buttons))
                    <div class="level-item">
                        <div class="buttons is-right">

                            @foreach ($buttons as $button)
                                {!! $button !!}
                            @endforeach

                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>


