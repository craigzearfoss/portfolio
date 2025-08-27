@if (!empty($success))
    @include('admin.components.message-success', ['message'=> $success ?? null])
@endif

@if (!empty($error))
    @include('admin.components.message-danger', ['message'=> $error ?? null])
@endif

@if (!empty($errors))
    @foreach ($errors as $error)
        @include('admin.components.message-danger', ['message'=> $error])
    @endforeach
@endif
