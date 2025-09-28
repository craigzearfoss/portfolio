<section class="section is-title-bar px-3 py-0">
    <div class="level">

        <div class="level-left">
            <div class="level-item">
                @if (!empty($breadcrumbs))
                    @include('front.components.breadcrumbs', [
                        'breadcrumbs' => $breadcrumbs
                    ])
                @endif
            </div>
        </div>

        <div class="level-right">
        </div>

    </div>
</section>
