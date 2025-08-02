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

                                <h2>About</h2>

                                <hr class="hr mt-2 mb-1  border-b border-gray-700 dark:border-gray-700" style="padding: 1px;" />

                                <div>
                                    <p class="pb-3 ">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse rhoncus ac mi ac sagittis. Etiam id nisi libero. Nullam et est non nibh convallis faucibus. Integer scelerisque, orci in sollicitudin laoreet, augue sem pellentesque dolor, at maximus ipsum justo vel erat. Integer hendrerit nisl turpis, sit amet pharetra purus efficitur eget. Nulla sagittis dui in pulvinar pulvinar. Pellentesque sed tempus orci. Mauris vel luctus eros, in porttitor nulla. Phasellus volutpat enim eu orci ultricies mollis.
                                    </p>
                                    <p class="pb-3">
                                        Donec id aliquet mi. Sed elementum ex vel ipsum porttitor, in efficitur velit congue. Pellentesque eget erat nisi. Aliquam porttitor enim id felis pharetra tristique vitae non sem. Suspendisse potenti. Quisque at lacus accumsan tellus iaculis cursus. Suspendisse ornare ante mi. Nullam vel nibh nec justo ultricies dapibus ut nec libero. Aenean sed diam mauris. Phasellus fermentum lacinia ipsum eu tincidunt. Fusce at dignissim lectus, id faucibus nunc.
                                    </p>
                                    <p class="pb-3">
                                        Suspendisse vitae posuere tortor. Donec iaculis sodales urna, et rutrum lacus convallis eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis vitae lectus in orci pretium blandit. Aliquam sed vehicula elit. In hac habitasse platea dictumst. Donec tincidunt tempus magna at semper. Vivamus quis turpis scelerisque, sagittis augue vel, ullamcorper metus. In hac habitasse platea dictumst. Curabitur vitae varius nunc, a maximus nunc.
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
