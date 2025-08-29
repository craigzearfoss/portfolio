<section class="section is-title-bar px-3 py-0">
    <div class="level">
        <div class="level-left">
            <div class="level-item">
                @if (!empty($breadcrumbs))
                    <ul>
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="is-size-6">
                                <a href="{{ $breadcrumb['url'] ?? '#' }}">{{ $breadcrumb['name'] ?? '#name#' }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="level-right">
            @if (!empty($buttons))
                <div class="level-item">
                    <div class="buttons is-right">
                        @foreach ($buttons as $button)
                            <a href="{{ $button['url'] ?? '' }}"
                               @if (!empty($button['target']))target="{{ $button['target'] }}" @endif
                               class="button is-small is-dark"
                            >
                                {!! $button['name'] ?? '#name#' !!}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
