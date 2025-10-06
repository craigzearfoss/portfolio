@if (!empty($success))
    @include('guest.components.message-success', ['message'=> $success ?? null])
@endif

@if (!empty($error))
    @include('guest.components.message-danger', ['message'=> $error ?? null])
@endif

@if (!empty($errorMessages))
    @foreach ($errorMessages as $element=>$elementMessages)
        @if (is_array($elementMessages))
            @foreach($elementMessages as $message)
                @include('guest.components.message-danger', ['message'=> $message])
            @endforeach
        @else
            @include('guest.components.message-danger', ['message'=> $elementMessages])
        @endif
    @endforeach
@endif
