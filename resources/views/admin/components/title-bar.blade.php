<section class="section is-title-bar">
    <div class="level">

        <div class="level-left">
            <div class="level-item">

                @if (!empty($breadcrumbs))
                    @include('admin.components.breadcrumbs', [
                        'breadcrumbs' => $breadcrumbs
                    ])
                @endif

            </div>
        </div>

        @if(!empty($prev) || !empty($next) || !empty($navButtons))

            <div class="level-right" style="display: inline-block;">

                @if (!empty($navButtons))

                    <div class="level-item mt-1" style="display: inline-block;">
                        <div class="buttons is-right pb-2">

                            @foreach ($navButtons as $navButton)
                                {!! $navButton !!}
                            @endforeach

                        </div>
                    </div>

                @endif

                @if(!empty($prev) || !empty($next))

                    <div style="display: inline-block; float: right;">
                        @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
                    </div>

                @endif

            </div>

        @endif

    </div>
</section>
