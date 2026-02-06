@php
    $menu       = $menu ?? 0;
    $menu_level = $menu_level ?? 0;
@endphp
<div class="columns">
    <div class="column is-2" style="min-width: 6rem;"><strong>menu</strong></div>
    <div class="column is-10 pl-0">
        <div>

            <div class="container" style="display: flex; gap: 1em;">

                <div class="item" style="max-width: 6em; flex: 1; white-space: nowrap;">
                    <span>
                        @include('admin.components.checkbox', [ 'checked' => !empty($menu) ])
                    </span>
                    <span><strong>include</strong></span>
                </div>

                <div class="item" style="flex: 1; white-space: nowrap;">
                    <span><strong>sequence:</strong></span>
                    <span>{{ $menu_level }}</span>
                </div>

            </div>

        </div>

    </div>
</div>
