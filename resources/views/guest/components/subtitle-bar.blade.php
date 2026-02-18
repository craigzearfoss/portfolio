<section class="hero is-hero-bar">

    <div class="subtitle-bar hero-body pt-0 pb-0">
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
                @if(!empty($prev) || !empty($next))
                    <div style="display: inline-block; float: right;">
                        @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
                    </div>
                @elseif (!empty($buttons))
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


