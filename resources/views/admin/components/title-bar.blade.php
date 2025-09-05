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
        </div>

    </div>
</section>
