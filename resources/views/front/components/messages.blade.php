@if (!empty($success))
    @include('front.components.message-success', ['message'=> $success ?? null])
@endif

@if (!empty($error))
    @include('front.components.message-danger', ['message'=> $error ?? null])
@endif

@if (!empty($errors))
    @foreach ($errors->all() as $message)
        @include('front.components.message-danger', ['message'=> $message])
    @endforeach
@endif
