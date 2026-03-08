@if (!empty($subtitle) || !empty($selectList) || !empty($prev) || !empty($next) || !empty($navButttons))

    <section class="hero is-hero-bar">

        <div class="subtitle-bar hero-body pt-0 pb-0">
            <div class="level">

                @if(!empty($subtitle) || !empty($selectList))

                    <div class="level-left" style="display: inline-block;">
                        <div class="level-item">
                            <h1 class="title is-size-4">
                                {!! $subtitle ?? '' !!}
                            </h1>
                            @if(!empty($selectList))
                                <span class="ml-2">
                                    {!! $selectList !!}
                                </span>
                            @endif
                        </div>
                    </div>

                @endif

                @if(!empty($navButtons))

                    <div class="level-right" style="display: inline-block;">
                        <div class="level-item">
                            <div class="buttons is-right">

                                @foreach ($navButtons as $navButton)
                                    {!! $navButton !!}
                                @endforeach

                            </div>
                        </div>
                    </div>

                @endif

            </div>
        </div>
    </section>

@endif

