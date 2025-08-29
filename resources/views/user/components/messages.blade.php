@if (!empty($success))
    @include('user.components.message-success', ['message'=> $success ?? null])
@endif

@if (!empty($error))
    @include('user.components.message-danger', ['message'=> $error ?? null])
@endif

@if (!empty($errors))
    @foreach ($errors as $error)
        @include('user.components.message-danger', ['message'=> $error])
    @endforeach
@endif
