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

                <p class="menu-label">{{ $resource->database['title'] }}</p>
                    <ul class="menu-list pl-2">
            @endif
            @php
                $currentSection = $resource->database['title'];
            @endphp

            <li>
                <a @if (strpos(Route::currentRouteName(), 'admin.' . $resource->type) !== 0)
                       href="{{ route('admin.' . $resource->type . '.index') }}"
                   @endif
               >
                    <span class="text-xl">
                        <i class="fa-solid  {{ $resource->icon ? $resource->icon : 'fa-circle' }}"></i></span>
                    <span class="menu-item-label">{{ !empty($resource->plural) ? $resource->plural : $resource->name }}</span>
                </a>
            </li>
        @endforeach

    </ul>

    @if (Auth::guard('admin') && Auth::guard('admin')->user()->root)

        <p class="menu-label">Root Admin Only</p>
        <ul class="menu-list">
            <li>
                <a href="{{ route('admin.dictionary.index') }}" class="has-icon">
                    <span class="icon has-update-mark"><i class="mdi mdi-table"></i></span>
                    <span class="menu-item-label">Dictionary</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.dictionary_database.index') }}">
                            <span>Databases</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dictionary_framework.index') }}">
                            <span>Frameworks</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dictionary_language.index') }}">
                            <span>Languages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dictionary_operating_system.index') }}">
                            <span>Operating Systems</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dictionary_server.index') }}">
                            <span>Servers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dictionary_stack.index') }}">
                            <span>Stacks</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    @endif

</aside>
