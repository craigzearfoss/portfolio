@if (session('success'))
    @include('user.components.message-success', ['message'=> session('success')])
@endif

@if (session('error'))
    @include('user.components.message-success', ['message'=> session('danger')])
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @include('user.components.message-info', ['message'=> $error])
    @endforeach
@endif
