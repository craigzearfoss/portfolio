@if (!empty($success))
    @include('admin.components.message-success', ['message'=> $success ?? null])
@endif

@if (!empty($error))
    @include('admin.components.message-danger', ['message'=> $error ?? null])
@endif

@if (!empty($errors))
    @foreach ($errors->all() as $message)
        @include('admin.components.message-danger', ['message'=> $message])
    @endforeach
@endif
