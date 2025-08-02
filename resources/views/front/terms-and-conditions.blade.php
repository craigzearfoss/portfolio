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

                            <h2>Terms and Conditions</h2>

                            <hr class="hr mt-2 mb-1  border-b border-gray-700 dark:border-gray-700" style="padding: 1px;" />

                            <div>
                                <p class="pb-3 ">
                                    Pellentesque eu massa nisi. Morbi vel lectus at nunc ultricies efficitur. Donec aliquam fermentum ultricies. Cras facilisis bibendum finibus. Curabitur quis tortor vitae elit vehicula pellentesque quis nec eros. Nulla semper pretium nunc, a pharetra turpis rhoncus ut. Nam pulvinar elit at massa consequat pellentesque. Proin ipsum nunc, auctor tempus iaculis in, iaculis in tortor. Sed ultricies erat quis ullamcorper placerat. Morbi et mauris turpis. Quisque interdum, lectus et gravida facilisis, arcu urna volutpat arcu, eu porttitor est mauris nec est. Curabitur pretium suscipit tincidunt. Morbi vestibulum tincidunt augue, quis auctor ligula facilisis vel. Nam aliquam arcu sapien, eu porta magna tempor at. Ut mollis rutrum hendrerit. Fusce rutrum feugiat porta.
                                </p>
                                <p class="pb-3">
                                    Fusce ultricies, nunc in hendrerit pellentesque, justo eros tempor ipsum, sed porta massa leo eu elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nulla facilisi. Quisque porta rhoncus felis. Vestibulum at augue dui. Sed convallis ultricies ligula id cursus. Mauris eget lorem eget elit fringilla auctor ut eget est. Aliquam blandit convallis leo, id semper nisl imperdiet vitae. Maecenas eleifend sapien eu nisi malesuada efficitur eget vitae ante. In risus leo, euismod sed orci sit amet, efficitur laoreet magna. Nunc vehicula nibh nec iaculis pharetra. Ut at risus rutrum, cursus turpis vel, mattis risus. Maecenas pulvinar luctus convallis. Nam porttitor sem sit amet interdum dictum.
                                </p>
                                <p class="pb-3">
                                    Integer mattis dui a justo posuere luctus. Nullam dictum congue orci, quis mollis mi feugiat in. Aliquam vulputate erat nec ultrices vestibulum. Nam suscipit, mauris a dictum dictum, odio elit varius enim, quis facilisis sapien augue nec metus. Nam volutpat, eros quis convallis posuere, magna arcu volutpat diam, sit amet rutrum ipsum nulla ac elit. Sed volutpat placerat massa, nec lobortis nulla eleifend non. Vestibulum vel nulla eget dolor laoreet pharetra eu eu metus. Ut eleifend, tellus eu sodales tristique, dolor purus posuere elit, ut maximus tellus diam et sem. Mauris efficitur, turpis at rutrum elementum, elit erat bibendum neque, ut sagittis ante tortor vitae risus.
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
