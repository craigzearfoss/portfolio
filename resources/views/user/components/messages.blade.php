@if (!empty($success))
    @include('user.components.message-success', ['message'=> $success ?? null])
@endif

@if (!empty($error))
    @include('user.components.message-danger', ['message'=> $error ?? null])
@endif

@if (!empty($errorMessages))
    @foreach ($errorMessages as $error)
        @include('user.components.message-danger', ['message'=> $error])
    @endforeach
@endif
