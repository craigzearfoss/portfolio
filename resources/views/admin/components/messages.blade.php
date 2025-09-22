@if (!empty($success))
    @include('admin.components.message-success', ['message'=> $success ?? null])
@endif

@if (!empty($error))
    @include('admin.components.message-danger', ['message'=> $error ?? null])
@endif

@if (!empty($errorMessages))
    @foreach ($errorMessages as $message)
        @include('admin.components.message-danger', ['message'=> $message])
    @endforeach
@endif
