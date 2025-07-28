<header class="header border-b border-gray-200 dark:border-gray-700">
    <div class="header-wrapper h-16">

        <div class="header-action header-action-start">
            <div id="side-nav-toggle" class="side-nav-toggle header-action-item header-action-item-hoverable">
                <div class="text-2xl">
                    <svg class="side-nav-toggle-icon-expand" stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    <svg class="side-nav-toggle-icon-collapsed hidden" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </div>
            </div>
            <div class="side-nav-toggle-mobile header-action-item header-action-item-hoverable" data-bs-toggle="modal" data-bs-target="#mobile-nav-drawer">
                <div class="text-2xl">
                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Header Nav Start end-->
        <!-- Header Nav End start -->

        <div class="header-action header-action-end">

            @include('admin.components.header-notification')

            @include('admin.components.header-config')

            @include('admin.components.header-user-dropdown')

        </div>

    </div>
</header>
