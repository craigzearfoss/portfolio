<section class="hero is-hero-bar">
    <div class="hero-body p-3">
        <div class="level">

            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-size-4">
                        {{ $subtitle ?? '#subtitle#' }}
                    </h1>
                </div>
            </div>

            <div class="level-right">
                @if (!empty($buttons))
                    <div class="level-item">
                        <div class="buttons is-right">
                            @foreach ($buttons as $button)
                                <a href="{{ $button['url'] ?? '' }}"
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


