<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

@include('admin.components.head')

<body>

<div id="root">

    <div class="app-layout-blank flex flex-auto flex-col h-[100vh]">
        <main class="h-full">

            @yield('content')

        </main>
    </div>
</div>

</body>
</html>
