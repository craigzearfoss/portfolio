@if (!empty($success))
    @include('front.components.message-success', ['message'=> $success ?? null])
@endif

@if (!empty($error))
    @include('front.components.message-danger', ['message'=> $error ?? null])
@endif

@if (!empty($errorMessages))
    @foreach ($errorMessages as $element=>$elementMessages)
        @if (is_array($elementMessages))
            @foreach($elementMessages as $message)
                @include('front.components.message-danger', ['message'=> $message])
            @endforeach
        @else
            @include('front.components.message-danger', ['message'=> $elementMessages])
        @endif
    @endforeach
@endif
