<ul class="list">
    @foreach($values as $value)
        <li class="list-item" style="list-style-type: circle;">
            {!! $value ?? '' !!}
        </li>
    @endforeach
</ul>
