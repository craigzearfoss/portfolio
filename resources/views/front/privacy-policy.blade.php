@extends('front.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('front.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('front.components.header')

                @include('front.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between">

                    <main class="h-full">
                        <div class="page-container relative h-full flex flex-auto flex-col px-4 sm:px-6 md:px-8 py-4 sm:py-6">
                            <div class="container mx-auto h-full">

                                <h2>Privacy Policy</h2>

                                <hr class="hr mt-2 mb-1  border-b border-gray-700 dark:border-gray-700" style="padding: 1px;" />

                                <div>
                                    <p class="pb-3 ">
                                        Vestibulum id libero ut dui pellentesque volutpat. Donec gravida magna ante, venenatis congue ipsum mattis eu. Suspendisse non dignissim ex. Curabitur sit amet molestie ligula. Duis tristique, arcu eu congue tincidunt, nibh orci fringilla est, ac lacinia turpis erat sit amet purus. Quisque non velit vitae lacus pretium bibendum. Mauris tempus enim ligula, eget sollicitudin ante suscipit nec. Nullam sagittis turpis maximus lacus cursus, ac venenatis magna lacinia. Cras bibendum luctus elit, ut pretium neque ultricies sed.
                                    </p>
                                    <p class="pb-3">
                                        Cras vitae mi in justo auctor cursus eu eu diam. Vestibulum malesuada dolor eu ex rhoncus tincidunt. Cras eros orci, pellentesque id ex sed, molestie posuere urna. Ut ut nunc luctus, viverra turpis id, pretium dui. Ut eget augue in sapien gravida aliquet in vitae ipsum. Nulla non augue dapibus, ullamcorper purus ultricies, imperdiet tortor. Sed dolor libero, scelerisque nec ligula at, euismod auctor arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut placerat erat vitae risus viverra semper. Praesent lobortis nisl at viverra auctor. Suspendisse ut posuere dolor. Aenean at magna scelerisque, volutpat metus nec, hendrerit dolor. Ut eu ornare sapien. Phasellus convallis ante dolor, id rutrum lorem feugiat vitae. Nullam tincidunt luctus urna. Suspendisse vitae ipsum in ligula imperdiet fringilla.
                                    </p>
                                    <p class="pb-3">
                                        Suspendisse consectetur scelerisque dignissim. Vestibulum feugiat lacus sit amet dapibus finibus. Integer congue metus ut enim euismod scelerisque. Sed efficitur efficitur dui a feugiat. Donec lacinia, mi id aliquet egestas, mauris erat molestie ante, tincidunt faucibus tellus nibh vitae orci. Sed in lacus libero. Praesent nec diam eget elit tincidunt sagittis ut sodales nisl. Praesent pulvinar rutrum posuere. Vivamus in sem vitae enim commodo aliquet ut in tellus. Mauris odio est, sagittis vitae mauris non, tempus ultrices nisi. Aliquam erat volutpat. Mauris mi velit, rutrum id nisl elementum, mattis efficitur libero. Fusce accumsan turpis quam, eget euismod turpis iaculis quis. Sed sagittis leo at magna elementum dictum. In eleifend feugiat posuere. Morbi luctus ut leo nec lobortis.
                                    </p>
                                </div>

                            </div>
                        </div>
                    </main>

                    @include('front.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
