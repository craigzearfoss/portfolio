<aside class="aside is-placed-left is-expanded" style="overflow-y: auto;">
    <div class="aside-tools">
        <div class="aside-tools-label">

            @if (Auth::guard('admin'))
                <a href="{{ route('admin.dashboard') }}">{{ config('app.name') }} Admin</a>
            @else
                <a href="{{ route('admin.index') }}">{{ config('app.name') }} Admin</a>
            @endif

        </div>
    </div>
    <ul class="menu is-menu-main">
        <?php /*
        <p class="menu-label">General</p>
        <ul class="menu-list">
            <li>
                <a href="index.html" class="is-active router-link-active has-icon">
                    <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
                    <span class="menu-item-label">Dashboard</span>
                </a>
            </li>
        </ul>
        */ ?>

        @php
            $currentSection = '';
        @endphp
        @foreach(\App\Models\Resource::all() as $i=>$resource)

            @if ($resource->database['title'] != $currentSection)
                @if (!empty($currentSection))
                    </ul>
                    <li id="menu-item-portfolio" class="menu-item-divider"></li>
                @endif

                <p class="menu-label pb-0 mb-0">
                    @if (!empty($resource->database) && ($resource->database['name'] !== config('app.database')))
                        <a href="{{ route('admin.'.strtolower($resource->database['name']).'.index') }}"
                           class="has-text-white"
                        >
                            {{ $resource->database['title'] }}
                        </a>
                    @else
                        {{ $resource->database['title'] }}
                    @endif
                </p>
                    <ul class="menu-list pl-2">
            @endif
            @php
                $currentSection = $resource->database['title'];
            @endphp

            <li>
                <a @if (strpos(Route::currentRouteName(), 'admin.' . $resource->path()) !== 0)
                       href="{{ route('admin.' . $resource->path() . '.index') }}"
                   @endif
               >
                    <span class="text-xl">
                        <i class="fa-solid  {{ $resource->icon ? $resource->icon : 'fa-circle' }}"></i></span>
                    <span class="menu-item-label">{{ !empty($resource->plural) ? $resource->plural : $resource->name }}</span>
                </a>
            </li>
        @endforeach

    </ul>

</aside>
