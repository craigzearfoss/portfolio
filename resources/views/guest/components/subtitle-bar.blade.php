<section class="hero is-hero-bar">
    <div class="hero-body p-3">
        <div class="level">

            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-size-4">
                        {{ $title ?? '' }}
                    </h1>
                    @if(!empty($selectList))
                        <span class="ml-2">
                            {!! $selectList !!}
                        </span>
                    @endif
                </div>
            </div>

            <div class="level-right">
                @if (!empty($buttons))
                    <div class="level-item">
                        <div class="buttons is-right">
                            @foreach ($buttons as $button)
                                <a href="{{ $button['href'] ?? '' }}"
                                   @if (!empty($button['target']))target="{{ $button['target'] }}" @endif
                                   class="button is-small is-dark my-0"
                                >
                                    {!! $button['name'] ?? '#name#' !!}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>


